(function() {
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const ctx = overlay.getContext('2d');

    // Configure dimensions
    video.width = 720;
    video.height = 560;
    overlay.width = video.width;
    overlay.height = video.height;

    // Define hand gestures
    const gestures = {
        peace: "Señal de Paz ✌️",
        palm: "Palma Abierta ✋",
        fist: "Puño Cerrado ✊",
        rockOn: "Rock and Roll 🤘",
        thumbsUp: "Pulgar Arriba 👍",
        pointingUp: "Señalando Arriba ☝️",
        ok: "Señal de OK 👌",
        pointing: "Señalando 👉"
    };

    // Function to calculate finger angles and distances
    function analyzeHandLandmarks(landmarks) {
        // We'll implement gesture detection logic here
        const fingerStates = {
            thumb: false,
            index: false,
            middle: false,
            ring: false,
            pinky: false
        };

        // Calculate finger extensions
        // Thumb
        fingerStates.thumb = landmarks[4].y < landmarks[3].y;
        // Index
        fingerStates.index = landmarks[8].y < landmarks[6].y;
        // Middle
        fingerStates.middle = landmarks[12].y < landmarks[10].y;
        // Ring
        fingerStates.ring = landmarks[16].y < landmarks[14].y;
        // Pinky
        fingerStates.pinky = landmarks[20].y < landmarks[18].y;

        return fingerStates;
    }

    // Function to recognize gestures
    function recognizeGesture(fingerStates) {
        const {thumb, index, middle, ring, pinky} = fingerStates;

        if (index && middle && !ring && !pinky) return gestures.peace;
        if (thumb && index && middle && ring && pinky) return gestures.palm;
        if (!thumb && !index && !middle && !ring && !pinky) return gestures.fist;
        if (thumb && index && !middle && !ring && pinky) return gestures.rockOn;
        if (thumb && !index && !middle && !ring && !pinky) return gestures.thumbsUp;
        if (!thumb && index && !middle && !ring && !pinky) return gestures.pointingUp;
        if (thumb && index && !middle && !ring && !pinky) return gestures.ok;
        if (thumb && !index && !middle && !ring && pinky) return gestures.pointing;

        return "Waiting for gesture...";
    }

    // Configure MediaPipe Hands
    const hands = new Hands({
        locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
        }
    });

    hands.setOptions({
        maxNumHands: 1,
        modelComplexity: 1,
        minDetectionConfidence: 0.7,
        minTrackingConfidence: 0.7
    });

    // Handler for MediaPipe results
    hands.onResults((results) => {
        ctx.clearRect(0, 0, overlay.width, overlay.height);
        
        // Draw mirrored video
        ctx.save();
        ctx.scale(-1, 1);
        ctx.drawImage(video, -overlay.width, 0, overlay.width, overlay.height);
        ctx.restore();

        if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
            // Draw hand landmarks
            results.multiHandLandmarks.forEach((landmarks) => {
                ctx.save();
                ctx.scale(-1, 1);
                drawConnectors(ctx, landmarks, HAND_CONNECTIONS, 
                    {color: '#00FF00', lineWidth: 2});
                drawLandmarks(ctx, landmarks, 
                    {color: '#FF0000', lineWidth: 1});
                ctx.restore();

                // Analyze hand gesture
                const fingerStates = analyzeHandLandmarks(landmarks);
                const gesture = recognizeGesture(fingerStates);

                // Display gesture name
                ctx.fillStyle = 'white';
                ctx.font = '48px Arial';
                ctx.fillText(gesture, 50, 50);
            });
        }
    });

    // Start camera and recognition
    async function startRecognition() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { width: 720, height: 560 }
            });
            video.srcObject = stream;
            await video.play();

            const camera = new Camera(video, {
                onFrame: async () => {
                    await hands.send({image: video});
                },
                width: 720,
                height: 560
            });
            camera.start();
        } catch (err) {
            console.error("Error starting hand recognition:", err);
        }
    }

    // Start when DOM is ready
    document.addEventListener('DOMContentLoaded', startRecognition);
})();