const form = document.getElementById("form");
const btn = document.getElementById("btn");
const success = document.getElementById("success");
const password = document.getElementById("password");
const toggle = document.getElementById("toggle");
const strength = document.querySelector(".strength");
const card = document.getElementById("card");

window.onload = () => {
    card.style.opacity = 0;
    card.style.transform = "translateY(40px)";
    setTimeout(() => {
        card.style.transition = "0.6s";
        card.style.opacity = 1;
        card.style.transform = "translateY(0)";
    }, 100);
};

document.addEventListener("mousemove", (e) => {
    const x = (window.innerWidth / 2 - e.pageX) / 30;
    const y = (window.innerHeight / 2 - e.pageY) / 30;
    card.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
});

const rules = {
    name: /^[A-Za-z\s]+$/,
    address: /^[A-Za-z0-9\s]+$/,
    phone: /^1[3-9]\d{9}$/,
    email: /^[^\s@]+@[^\s@]+\.(com|cn)$/,
    username: /^[A-Za-z0-9]{6,}$/,
    password: /^[A-Za-z0-9]{6,}$/
};

document.querySelectorAll("input").forEach(input => {
    input.addEventListener("input", () => validate(input));
});

function validate(input) {
    const value = input.value.trim();
    const name = input.name;
    const error = input.parentElement.querySelector(".error");

    if (!value) {
        error.textContent = "Required";
        input.classList.add("invalid");
        return false;
    }

    if (!rules[name].test(value)) {
        error.textContent = "Invalid format";
        input.classList.add("invalid");
        return false;
    }

    error.textContent = "";
    input.classList.remove("invalid");
    input.classList.add("valid");
    return true;
}

password.addEventListener("input", () => {
    const val = password.value;
    let score = 0;

    if (val.length >= 6) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;

    strength.style.width = score * 33 + "%";
});

toggle.onclick = () => {
    password.type = password.type === "password" ? "text" : "password";
};

form.addEventListener("submit", (e) => {
    let valid = true;

    document.querySelectorAll("input").forEach(i => {
        if (!validate(i)) valid = false;
    });

    if (!valid) {
        e.preventDefault();
        return;
    }

    btn.classList.add("loading");
});