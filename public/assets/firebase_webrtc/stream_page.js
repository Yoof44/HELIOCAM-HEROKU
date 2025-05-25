document.addEventListener('DOMContentLoaded', function () {
    let cameraCount = 1;
    let cameraStreams = {};
    let selectedCameraId = 1;
    let zoomLevel = {}; // Stores zoom level per camera

    function setupCamera(cameraId) {
        navigator.mediaDevices.enumerateDevices().then(devices => {
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            if (videoDevices.length === 0) {
                alert('No cameras found!');
                return;
            }

            startCameraStream(cameraId, videoDevices[0].deviceId);
        });
    }

    function startCameraStream(cameraId, deviceId) {
        if (cameraStreams[cameraId]) {
            cameraStreams[cameraId].getTracks().forEach(track => track.stop());
        }

        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: deviceId } }, audio: false })
            .then(stream => {
                cameraStreams[cameraId] = stream;
                const videoElement = document.getElementById(`remoteVideo${cameraId}`);
                if (videoElement) {
                    videoElement.srcObject = stream;
                }
                zoomLevel[cameraId] = 1; // Reset zoom
                updateZoomUI(cameraId, 1);
            })
            .catch(err => console.error(`Error accessing camera ${cameraId}:`, err));
    }

    window.addCamera = function () {
        if (cameraCount >= 4) {
            alert('Maximum of 4 cameras reached');
            return;
        }
        cameraCount++;
        const videoGrid = document.getElementById('videoGrid');
        const cameraContainer = document.createElement('div');
        cameraContainer.classList.add('col-lg-6', 'col-md-6', 'col-12');
        cameraContainer.id = `cameraContainer_${cameraCount}`;
        cameraContainer.innerHTML = `
            <div class="video-container">
                <video id="remoteVideo${cameraCount}" autoplay playsinline></video>
                <button class="settings-btn btn btn-sm" onclick="openSettings(${cameraCount})"><i class="fas fa-cog"></i></button>
                 <div class="resize-handle top-left"></div>
                <div class="resize-handle top-right"></div>
                <div class="resize-handle bottom-left"></div>
                <div class="resize-handle bottom-right"></div>
            </div>
        `;
        videoGrid.appendChild(cameraContainer);
        setupCamera(cameraCount);
    }

    window.removeCamera = function () {
        if (cameraCount <= 1) return;
        document.getElementById(`cameraContainer_${cameraCount}`).remove();
        cameraStreams[cameraCount]?.getTracks().forEach(track => track.stop());
        delete cameraStreams[cameraCount];
        delete zoomLevel[cameraCount];
        cameraCount--;
    }

    window.openSettings = function (cameraId) {
        selectedCameraId = cameraId;
        navigator.mediaDevices.enumerateDevices().then(devices => {
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            const cameraSelect = document.getElementById('cameraSelect');
            cameraSelect.innerHTML = '';

            videoDevices.forEach(device => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.textContent = device.label || `Camera ${cameraId}`;
                cameraSelect.appendChild(option);
            });

            // Auto-select the current device
            const currentStream = cameraStreams[selectedCameraId];
            if (currentStream) {
                const currentDeviceId = currentStream.getVideoTracks()[0].getSettings().deviceId;
                cameraSelect.value = currentDeviceId;
            }
        });

        // Sync switch state
        let tracks = cameraStreams[selectedCameraId]?.getVideoTracks();
        if (tracks) {
            document.getElementById('toggleCameraSwitch').checked = tracks[0].enabled;
        }

        // Sync zoom slider value
        updateZoomUI(selectedCameraId, zoomLevel[selectedCameraId] || 1);

        // Show settings modal
        new bootstrap.Modal(document.getElementById('cameraSettingsModal')).show();
    }

    // Change Camera Device
    document.getElementById('cameraSelect').addEventListener('change', function () {
        const selectedDeviceId = this.value;
        startCameraStream(selectedCameraId, selectedDeviceId);
    });

    // Toggle Camera On/Off
    window.toggleCamera = function () {
        if (!cameraStreams[selectedCameraId]) return;
        let tracks = cameraStreams[selectedCameraId].getVideoTracks();
        tracks.forEach(track => track.enabled = !track.enabled);
        document.getElementById('toggleCameraSwitch').checked = tracks[0].enabled;
    }

    // Adjust Zoom via Slider
    window.updateZoom = function (value) {
        if (!cameraStreams[selectedCameraId]) return;
        let track = cameraStreams[selectedCameraId].getVideoTracks()[0];
        let capabilities = track.getCapabilities();
        if (capabilities.zoom) {
            let newZoom = parseFloat(value);
            track.applyConstraints({ advanced: [{ zoom: newZoom }] });
            zoomLevel[selectedCameraId] = newZoom;
        }
    }

    function updateZoomUI(cameraId, zoomValue) {
        document.getElementById('zoomSlider').value = zoomValue;
        document.getElementById('zoomValueLabel').textContent = `Zoom: ${zoomValue.toFixed(1)}x`;
    }

    document.getElementById('zoomSlider').addEventListener('input', function () {
        updateZoom(this.value);
        document.getElementById('zoomValueLabel').textContent = `Zoom: ${parseFloat(this.value).toFixed(1)}x`;
    });

    document.getElementById('addCameraBtn').addEventListener('click', addCamera);
    document.getElementById('removeCameraBtn').addEventListener('click', removeCamera);
    setupCamera(1);
});
