
document.addEventListener("DOMContentLoaded", function () {
    // Тіркелу формасын тексеру
    const registerForm = document.getElementById("registerForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            const name = document.getElementById("fullName").value.trim();
            const email = document.getElementById("registerEmail").value.trim();
            const password = document.getElementById("registerPassword").value;
            const confirm = document.getElementById("confirmPassword").value;
            const message = document.getElementById("registerMessage");

            if (!name || !email) {
                message.textContent = "Барлық қажетті өрісті толтырыңыз.";
                message.style.color = "#ff8585";
                event.preventDefault();
                return;
            }

            if (password.length < 6) {
                message.textContent = "Құпиясөз кемінде 6 таңбадан тұруы керек.";
                message.style.color = "#ff8585";
                event.preventDefault();
                return;
            }

            if (password !== confirm) {
                message.textContent = "Құпиясөздер бірдей емес!";
                message.style.color = "#ff8585";
                event.preventDefault();
                return;
            }

            message.textContent = "";
        });
    }

    // Кіру формасын тексеру
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            const email = document.getElementById("loginEmail").value.trim();
            const password = document.getElementById("loginPassword").value;
            const message = document.getElementById("loginMessage");

            if (!email || !password) {
                message.textContent = "Email мен құпиясөзді енгізіңіз.";
                message.style.color = "#ff8585";
                event.preventDefault();
                return;
            }

            message.textContent = "";
        });
    }

    // Іс-шараларды санат бойынша сүзу
    const eventFilter = document.getElementById("eventFilter");

    if (eventFilter) {
        eventFilter.addEventListener("change", function () {
            const selected = eventFilter.value;
            const cards = document.querySelectorAll(".event-card");
            let visibleCount = 0;

            cards.forEach(function (card) {
                const matches =
                    selected === "all" ||
                    card.dataset.category === selected;

                card.hidden = !matches;

                if (matches) {
                    visibleCount++;
                }
            });

            document.getElementById("noEvents").hidden = visibleCount !== 0;
        });
    }
});
