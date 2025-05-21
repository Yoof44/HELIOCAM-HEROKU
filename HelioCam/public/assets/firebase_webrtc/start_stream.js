import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase,get, ref, set, push, onChildAdded, onValue } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";


const firebaseConfig = { 
    apiKey: "AIzaSyB5IBiji1ZVN5Sx3ae7xj_3xY0WNLTW7gg",
    authDomain: "heliocam-dad8f.firebaseapp.com",
    databaseURL: "https://heliocam-dad8f-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "heliocam-dad8f",
    storageBucket: "heliocam-dad8f.appspot.com",
    messagingSenderId: "393709127499",
    appId: "1:393709127499:web:68012f120209bb08738ace",
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getDatabase(app);

const peerConnectionConfig = {
    iceServers: [
        { urls: "stun:stun.relay.metered.ca:80" },
        {
            urls: "turn:asia.relay.metered.ca:80?transport=tcp",
            username: "08a10b202c595304495012c2",
            credential: "JnsH2+jc2q3/uGon"
        }
    ]
};


const peerConnection = new RTCPeerConnection(peerConnectionConfig);

async function startStreaming(user) {
    if (!user || !user.email) {
        console.log("No authenticated user.");
        return;
    }

    const session_n = new URLSearchParams(window.location.search).get("session_n");
    if (!session_n) {
        console.log("Session number missing from URL.");
        return;
    }

    const formattedEmail = user.email.replace(/\./g, "_");
    const sessionRef = ref(db, `users/${formattedEmail}/sessions/${session_n}`);
    const offerRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/Offer`);
    const answerRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/Answer`);
    const candidatesRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/ice_candidates`);

    try {
        const cameraContainer = document.querySelector(".camera-container");
        const canvas = document.getElementById("streamCanvas");
        const ctx = canvas.getContext("2d");

        canvas.width = cameraContainer.offsetWidth;
        canvas.height = cameraContainer.offsetHeight;


        function updateCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            html2canvas(cameraContainer).then((divCanvas) => {
                ctx.drawImage(divCanvas, 0, 0, canvas.width, canvas.height);
                requestAnimationFrame(updateCanvas);
            });
        }

        updateCanvas(); 

        const stream = canvas.captureStream(60); 


        stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
        console.log("Canvas stream added.");

        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        await set(offerRef, offer.sdp);
        console.log("Offer SDP stored in Firebase.");

        let candidateIndex = 1;

        peerConnection.onicecandidate = async (event) => {
            if (event.candidate) {
                const candidateKey = `candidate_${candidateIndex}`;
                const candidateRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/ice_candidates/${candidateKey}`);
                
                await set(candidateRef, event.candidate.toJSON());
                console.log(`ICE candidate stored in Firebase as ${candidateKey}.`);
                
                candidateIndex++;
            }
        };

        onValue(candidatesRef, (snapshot) => {
            if (snapshot.exists()) {
                snapshot.forEach((childSnapshot) => {
                    const candidateData = childSnapshot.val();
                    if (candidateData) {
                        const candidate = new RTCIceCandidate(candidateData);
                        peerConnection.addIceCandidate(candidate)
                            .then(() => console.log(`Added remote ICE candidate:`, candidate))
                            .catch(error => console.error("Error adding ICE candidate:", error));
                    }
                });
            }
        });

        onChildAdded(candidatesRef, (snapshot) => {
            const candidateData = snapshot.val();
            if (candidateData) {
                const candidate = new RTCIceCandidate(candidateData);
                peerConnection.addIceCandidate(candidate)
                    .then(() => console.log("Added remote ICE candidate:", candidate))
                    .catch(error => console.error("Error adding ICE candidate:", error));
            }
        });

        onValue(answerRef, async (snapshot) => {
            if (snapshot.exists()) {
                console.log("New Answer detected. Setting remote description...");
                const answerSDP = snapshot.val();
                await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: "answer", sdp: answerSDP }));
                console.log("Remote Answer SDP set.");
            }
        });

    } catch (error) {
        console.error("Error starting stream:", error);
    }
}

onAuthStateChanged(auth, (user) => {
    if (user) {                     
        startStreaming(user);
    } else {
        console.log("User not logged in.");
    }
});

function monitorDisconnection(user) {
    if (!user || !user.email) return;

    const formattedEmail = user.email.replace(/\./g, "_");
    const session_n = new URLSearchParams(window.location.search).get("session_n");
    if (!session_n) return;

    const disconnectRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/disconnect`);

    setInterval(async () => {
        try {
            const snapshot = await get(disconnectRef);
            if (snapshot.exists() && snapshot.val() === 1) {
                console.log("Disconnection detected. Creating a new offer...");

                const newOffer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(newOffer);

                await set(ref(db, `users/${formattedEmail}/sessions/${session_n}/Offer`), newOffer.sdp);
                console.log("New Offer SDP stored in Firebase.");

                // Delete the disconnect flag after handling it
                await set(disconnectRef, null);
                console.log("Disconnect flag reset.");
            }
        } catch (error) {
            console.error("Error checking disconnection status:", error);
        }
    }, 100); // Check every 5 seconds
}

onAuthStateChanged(auth, (user) => {
    if (user) {                     
        startStreaming(user);
        monitorDisconnection(user); // Start monitoring disconnection in the background
    } else {
        console.log("User not logged in.");
    }
});
