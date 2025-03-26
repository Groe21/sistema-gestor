(function() {
    const video = document.getElementById('video');
    const overlay = document.getElementById('overlay');
    const ctx = overlay.getContext('2d');

    // Configurar dimensiones
    video.width = 720;
    video.height = 560;
    overlay.width = video.width;
    overlay.height = video.height;

    // Variables del juego
    // En las variables iniciales del juego
    const gameState = {
        ball: {
            x: overlay.width / 2,
            y: overlay.height / 2,
            dx: 3,        // Reducido de 5 a 3
            dy: -3,       // Reducido de -5 a -3
            radius: 15
        },
        blocks: [],
        score: 0,
        gameOver: false,
        gameWon: false
    };

    // Inicializar bloques
    function initializeBlocks() {
        const rows = 3;
        const cols = 5;
        const blockWidth = 100;
        const blockHeight = 30;
        
        for(let i = 0; i < rows; i++) {
            for(let j = 0; j < cols; j++) {
                gameState.blocks.push({
                    x: j * (blockWidth + 10) + 60,
                    y: i * (blockHeight + 10) + 30,
                    width: blockWidth,
                    height: blockHeight,
                    active: true
                });
            }
        }
    }

    // Función para reiniciar el juego
    // En la función resetGame
    function resetGame() {
        gameState.ball = {
            x: overlay.width / 2,
            y: overlay.height / 2,
            dx: 5,
            dy: -5,
            radius: 15
        };
        gameState.score = 0;
        gameState.gameOver = false;
        gameState.gameWon = false;
        gameState.blocks = [];
        initializeBlocks();
    }

    // Agregar evento de tecla espacio
    document.addEventListener('keydown', (event) => {
        if (event.code === 'Space' && (gameState.gameOver || gameState.gameWon)) {
            resetGame();
        }
    });

    // Modificar la función updateBall para mejorar las colisiones
    // En la función updateBall
    function updateBall(handLandmark) {
        const ball = gameState.ball;
        
        // Mover la pelota
        ball.x += ball.dx;
        ball.y += ball.dy;
        
        // Reducir el incremento gradual de velocidad
        if (Math.abs(ball.dy) < 10) {  // Reducido de 15 a 10
            ball.dy *= 1.0005;         // Reducido de 1.001 a 1.0005
        }
        
        // Mejorar rebotes en los bordes
        const margin = 5; // Margen para evitar que la pelota se pegue
        
        if(ball.x + ball.radius > overlay.width - margin) {
            ball.x = overlay.width - ball.radius - margin;
            ball.dx *= -1;
        } else if(ball.x - ball.radius < margin) {
            ball.x = ball.radius + margin;
            ball.dx *= -1;
        }
        
        if(ball.y - ball.radius < margin) {
            ball.y = ball.radius + margin;
            ball.dy *= -1;
        }
    
        // Colisión con la mano (coordenadas invertidas para efecto espejo)
        // En la función updateBall, modificar la parte de colisión con la mano
        // En la función updateBall, dentro de la colisión con la mano
        if(handLandmark) {
            const handX = (1 - handLandmark[9].x) * overlay.width;
            const handY = handLandmark[9].y * overlay.height;
            const handWidth = 120;
            const handHeight = 40;
            
            // Detectar movimiento lateral de la mano
            const handVelocityX = handX - (gameState.lastHandX || handX);
            gameState.lastHandX = handX;
            
            if(ball.y + ball.radius > handY - handHeight && 
               ball.y + ball.radius < handY + handHeight && 
               ball.x > handX - handWidth && 
               ball.x < handX + handWidth) {
                
                // Mejorar el cálculo del ángulo de rebote
                const hitPosition = (ball.x - (handX - handWidth)) / (handWidth * 2);
                
                // Añadir factor de dirección basado en la posición relativa
                const directionFactor = (ball.x - handX) / handWidth;
                
                // Influenciar dirección con el movimiento de la mano y la posición
                const handInfluence = Math.sign(handVelocityX) * Math.min(Math.abs(handVelocityX * 0.3), 5);
                ball.dx = 5 * directionFactor + handInfluence;
                
                // Ajustar velocidad vertical con un poco de variación
                const verticalFactor = Math.abs(directionFactor) * 0.5;
                ball.dy = (-Math.abs(ball.dy) - 1) * (1 - verticalFactor);
                
                // Asegurar velocidad mínima horizontal
                if (Math.abs(ball.dx) < 2) {
                    ball.dx = Math.sign(ball.dx) * 2;
                }
                
                // Limitar velocidad máxima
                const maxSpeed = 10;
                if (Math.abs(ball.dx) > maxSpeed) {
                    ball.dx = Math.sign(ball.dx) * maxSpeed;
                }
                
                // Asegurar velocidad mínima
                if (Math.abs(ball.dy) < 5) ball.dy = -5;
            }
        }
        
        // Colisión con bloques
        gameState.blocks.forEach(block => {
            if(block.active && 
               ball.x > block.x && 
               ball.x < block.x + block.width &&
               ball.y > block.y && 
               ball.y < block.y + block.height) {
                block.active = false;
                ball.dy *= -1;
                gameState.score += 10;
            }
        });
        
        // En la función updateBall, agregar después de los rebotes:
        // Reiniciar si la pelota cae
        if(ball.y > overlay.height) {
            gameState.gameOver = true;
            ball.dx = 0;
            ball.dy = 0;
        }
    
        // Verificar victoria
        if (gameState.blocks.every(block => !block.active)) {
            gameState.gameWon = true;
            ball.dx = 0;
            ball.dy = 0;
        }
    
    // En la función onResults, después de dibujar el puntaje:
            // Texto sin espejo
            ctx.fillStyle = 'white';
            ctx.font = '24px Arial';
            ctx.fillText(`Puntaje: ${gameState.score}`, 10, 30);
    
            // Mostrar mensajes de fin de juego
            if (gameState.gameOver) {
                ctx.fillStyle = 'red';
                ctx.font = '48px Arial';
                ctx.fillText('¡GAME OVER!', overlay.width/2 - 150, overlay.height/2);
                ctx.font = '24px Arial';
                ctx.fillText('Presiona ESPACIO para reiniciar', overlay.width/2 - 150, overlay.height/2 + 50);
            }
            
            if (gameState.gameWon) {
                ctx.fillStyle = 'green';
                ctx.font = '48px Arial';
                ctx.fillText('¡GANASTE! 🎉', overlay.width/2 - 150, overlay.height/2);
                ctx.font = '24px Arial';
                ctx.fillText('Presiona ESPACIO para reiniciar', overlay.width/2 - 150, overlay.height/2 + 50);
            }
    }

    // Configurar MediaPipe Hands
    const hands = new Hands({
        locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
        }
    });

    hands.setOptions({
        maxNumHands: 2,
        modelComplexity: 1,
        minDetectionConfidence: 0.5,
        minTrackingConfidence: 0.5
    });

    // Handler para resultados de MediaPipe
    hands.onResults((results) => {
        ctx.clearRect(0, 0, overlay.width, overlay.height);
        
        // Dibujar video espejado
        ctx.save();
        ctx.scale(-1, 1);
        ctx.drawImage(video, -overlay.width, 0, overlay.width, overlay.height);
        ctx.restore();
    
        // Dibujar bloques (siempre visibles)
        gameState.blocks.forEach(block => {
            if(block.active) {
                ctx.fillStyle = '#FF6B6B';
                ctx.fillRect(block.x, block.y, block.width, block.height);
            }
        });
        
        // Mostrar puntaje (siempre visible)
        ctx.fillStyle = 'white';
        ctx.font = '24px Arial';
        ctx.fillText(`Puntaje: ${gameState.score}`, 10, 30);
    
        // Mostrar mensajes de fin de juego
        if (gameState.gameOver) {
            ctx.fillStyle = 'red';
            ctx.font = '48px Arial';
            ctx.fillText('¡GAME OVER!', overlay.width/2 - 150, overlay.height/2);
            ctx.font = '24px Arial';
            ctx.fillText('Presiona ESPACIO para reiniciar', overlay.width/2 - 150, overlay.height/2 + 50);
        }
        
        if (gameState.gameWon) {
            ctx.fillStyle = 'green';
            ctx.font = '48px Arial';
            ctx.fillText('¡GANASTE! 🎉', overlay.width/2 - 150, overlay.height/2);
            ctx.font = '24px Arial';
            ctx.fillText('Presiona ESPACIO para reiniciar', overlay.width/2 - 150, overlay.height/2 + 50);
        }

        // Dibujar pelota (siempre visible a menos que sea game over)
        if (!gameState.gameOver && !gameState.gameWon) {
            ctx.beginPath();
            ctx.arc(gameState.ball.x, gameState.ball.y, gameState.ball.radius, 0, Math.PI * 2);
            ctx.fillStyle = '#FFFF00';
            ctx.fill();
            ctx.closePath();
        }

        // Actualizar posición de la pelota si hay manos detectadas
        if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
            results.multiHandLandmarks.forEach((landmarks) => {
                // Dibujar manos
                ctx.save();
                ctx.scale(-1, 1);
                drawConnectors(ctx, landmarks, HAND_CONNECTIONS, 
                    {color: '#00FF00', lineWidth: 2});
                drawLandmarks(ctx, landmarks, 
                    {color: '#FF0000', lineWidth: 1});
                ctx.restore();
    
                updateBall(landmarks);
            });
        }
    });

    // Iniciar cámara y juego
    async function startGame() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { width: 720, height: 560 }
            });
            video.srcObject = stream;
            await video.play();
    
            initializeBlocks(); // Asegúrate de que esta línea esté aquí
            
            const camera = new Camera(video, {
                onFrame: async () => {
                    await hands.send({image: video});
                },
                width: 720,
                height: 560
            });
            camera.start();
        } catch (err) {
            console.error("Error iniciando el juego:", err);
        }
    }

    // Iniciar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', startGame);
})();