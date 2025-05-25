import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-auth.js";
import { getDatabase, ref, get, set } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-database.js";
import "https://webrtc.github.io/adapter/adapter-latest.js";


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

function getCookie(name) {
    let match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? match[2] : null;
}

function getSessionNFromURL() {
    const params = new URLSearchParams(window.location.search);
    for (const [key] of params) {
        if (key.startsWith("session_")) {
            console.log("Collected session_n from URL:", key);
            return key;
        }
    }
    return null;
}

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

peerConnection.onicecandidate = async (event) => {
    if (event.candidate) {
        console.log("New ICE candidate:", event.candidate);

        const user = auth.currentUser;
        if (!user || !user.email) {
            console.log("No authenticated user to store ICE candidates.");
            return;
        }

        const session_n = getSessionNFromURL();
        if (!session_n) {
            console.log("No session_n found in URL.");
            return;
        }

        const formattedEmail = user.email.replace(/\./g, "_");
        const candidatesRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/ice_candidates`);

        try {
            // Retrieve existing candidates first
            const candidatesSnap = await get(candidatesRef);
            let candidates = candidatesSnap.exists() ? candidatesSnap.val() : {};

            // Determine the next candidate key (candidate_1, candidate_2, ...)
            let candidateNumber = Object.keys(candidates).length + 1;
            let candidateKey = `candidate_${candidateNumber}`;

            // Store the new ICE candidate under the computed key
            const newCandidateRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/ice_candidates/${candidateKey}`);
            await set(newCandidateRef, {
                candidate: event.candidate.candidate,
                sdpMid: event.candidate.sdpMid,
                sdpMLineIndex: event.candidate.sdpMLineIndex
            });

            console.log(`ICE candidate stored as ${candidateKey} in Firebase.`);
        } catch (error) {
            console.error("Error storing ICE candidate:", error);
        }
    }
};





peerConnection.ontrack = (event) => {
    console.log("Remote stream received.");
    const stream = event.streams[0];
    
    // Call the handler function in the main page
    if (window.handleRemoteStream) {
        window.handleRemoteStream(stream, 1); // Start with camera 1
    } else {
        // Fallback if handler isn't available
        const remoteVideo = document.getElementById("remoteVideo");
        if (remoteVideo) {
            remoteVideo.srcObject = stream;
        }
    }
};

async function loadSessionData(user) {
    if (!user || !user.email) {
        console.log("No authenticated user found.");
        return;
    }

    const session_n = getSessionNFromURL();
    if (!session_n) {
        console.log("No session_n found in URL.");
        return;
    }

    const formattedEmail = user.email.replace(/\./g, "_");
    const cookieName = `logininfo_${formattedEmail}`;
    const loginInfoN = getCookie(cookieName);

    if (!loginInfoN) {
        console.log("No logininfo_n cookie found.");
        return;
    }

    const sessionsAddedRef = ref(db, `users/${formattedEmail}/${loginInfoN}/sessions_added/${session_n}`);
    try {
        const sessionsAddedSnap = await get(sessionsAddedRef);
        if (!sessionsAddedSnap.exists()) {
            console.log("Session not found in sessions_added. Access denied.");
            return;
        }

        const sessionsRef = ref(db, `users/${formattedEmail}/sessions/${session_n}`);
        const sessionsSnap = await get(sessionsRef);

        if (!sessionsSnap.exists()) {
            console.log("Session exists in sessions_added but not found in sessions.");
            return;
        }

        const sessionData = sessionsSnap.val();
        console.log("Session Data Loaded:", sessionData);

        if (sessionData.Offer) {
            console.log("SDP from Offer:", sessionData.Offer);
            await handleOffer(sessionData.Offer, formattedEmail, session_n);
        } else {
            console.log("No Offer SDP found in session.");
        }
    } catch (error) {
        console.error("Error loading session data:", error);
    }
}

async function handleOffer(offerSDP, userEmail, session_n) {
    try {
        if (typeof offerSDP !== "string") {
            console.error("Invalid SDP Offer format:", offerSDP);
            return;
        }

        let parsedOffer = { type: "offer", sdp: offerSDP };
        await peerConnection.setRemoteDescription(new RTCSessionDescription(parsedOffer));
        console.log("Offer set as remote description.");

        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        console.log("Created and set local answer:", answer.sdp);

        const answerRef = ref(db, `users/${userEmail}/sessions/${session_n}/Answer`);
        await set(answerRef, answer.sdp); // Store only the SDP as "Answer": sdp...
        console.log("Answer SDP sent to Firebase.");
    } catch (error) {
        console.error("Error handling offer:", error);peerConnection.onicecandidate = async (event) => {
    if (event.candidate) {
        console.log("New ICE candidate:", event.candidate);

        const user = auth.currentUser;
        if (!user || !user.email) {
            console.log("No authenticated user to store ICE candidates.");
            return;
        }

        const session_n = getSessionNFromURL();
        if (!session_n) {
            console.log("No session_n found in URL.");
            return;
        }

        const formattedEmail = user.email.replace(/\./g, "_");
        const candidatesRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/ice_candidates`);

        try {
            // Push new ICE candidate to Firebase
            await set(candidatesRef, event.candidate.toJSON());
            console.log("ICE candidate stored in Firebase.");
        } catch (error) {
            console.error("Error storing ICE candidate:", error);
        }
    }
};

    }
}

navigator.mediaDevices.getUserMedia({ audio: true })
    .then((stream) => {
        stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
        console.log("Microphone stream added.");
    })
    .catch(error => console.error("Error accessing microphone:", error));

onAuthStateChanged(auth, (user) => {
    if (user) {
        loadSessionData(user);
    } else {
        console.log("User not logged in.");
    }
});

window.addEventListener("beforeunload", async () => {
    const user = auth.currentUser;
    if (user && user.email) {
        const session_n = getSessionNFromURL();
        if (session_n) {
            const formattedEmail = user.email.replace(/\./g, "_");
            
            // References to delete
            const disconnectRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/disconnect`);
            const iceCandidatesRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/ice_candidates`);
            const answerRef = ref(db, `users/${formattedEmail}/sessions/${session_n}/Answer`);

            try {
                // Set disconnect flag
                await set(disconnectRef, 1);
                console.log("Disconnect flag set to 1 in Firebase.");

                // Remove ICE candidates
                await set(iceCandidatesRef, null);
                console.log("Deleted ice_candidates from Firebase.");

        
                await set(answerRef, null);
                console.log("Deleted Answer from Firebase.");
            } catch (error) {
                console.error("Error cleaning up session data:", error);
            }
        }
    }
});
