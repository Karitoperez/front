import "tailwindcss/tailwind.css";
import "flowbite";
import "./bootstrap";
import "./slider";
import Pusher from 'pusher-js';


window.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("background");
    if (canvas) {
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const colors = ["#4f46e5", "#6b7280", "#3357FF"]; // Colores para círculos, cuadrados y triángulos respectivamente

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.radius = Math.random() * 8 + 10; // Tamaño aleatorio para círculos
                this.side = Math.random() * 2 + 10; // Lado aleatorio para cuadrados
                this.color = colors[Math.floor(Math.random() * colors.length)]; // Color aleatorio
                this.type = Math.floor(Math.random() * 3); // 0 para círculos, 1 para cuadrados, 2 para triángulos
                this.speedX = Math.random() * 2 - 1;
                this.speedY = Math.random() * 2 - 1;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x < 0 || this.x > canvas.width) {
                    this.speedX = -this.speedX;
                }

                if (this.y < 0 || this.y > canvas.height) {
                    this.speedY = -this.speedY;
                }
            }

            draw() {
                ctx.beginPath();
                if (this.type === 0) {
                    // Dibujar círculo
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                } else if (this.type === 1) {
                    // Dibujar cuadrado
                    ctx.rect(
                        this.x - this.side / 2,
                        this.y - this.side / 2,
                        this.side,
                        this.side
                    );
                } else {
                    // Dibujar triángulo
                    ctx.moveTo(this.x, this.y - this.radius);
                    ctx.lineTo(
                        this.x - (this.radius * Math.sqrt(3)) / 2,
                        this.y + this.radius / 2
                    );
                    ctx.lineTo(
                        this.x + (this.radius * Math.sqrt(3)) / 2,
                        this.y + this.radius / 2
                    );
                    ctx.closePath();
                }
                ctx.fillStyle = this.color;
                ctx.fill();
            }
        }

        function init() {
            for (let i = 0; i < 100; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach((particle) => {
                particle.update();
                particle.draw();
            });
        }

        init();
        animate();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    let dropdowns = document.querySelectorAll(".dropdown");
    let submenus = document.querySelectorAll(".submenu");

    dropdowns.forEach((dropdown) => {
        dropdown.addEventListener("click", function (event) {
            let submenu = this.nextElementSibling;
            submenu.classList.toggle("mostrar");
            event.stopPropagation(); // Evita que el clic se propague al documento
        });
    });

    const alerta = document.querySelector(".alerta");

    if (alerta) {
        const btnCerrarAlerta = document.querySelector(".btnCerrarAlerta");

        btnCerrarAlerta.addEventListener("click", function () {
            alerta.parentNode.removeChild(alerta);
        });
        setTimeout(() => {
            alerta.parentNode.removeChild(alerta);
        }, 3000);
    }

    document.addEventListener("click", function (event) {
        dropdowns.forEach((dropdown) => {
            let submenu = dropdown.nextElementSibling;
            if (
                !dropdown.contains(event.target) &&
                !submenu.contains(event.target)
            ) {
                submenu.classList.remove("mostrar");
            }
        });
    });
});
