const body = document.querySelector("body");
const overlay = document.querySelector("#overlay");

// Sidebar toggle
const side_menu_toggle = document.querySelector(".menu-toggle");
const sidebar = document.querySelector(".sidebar");
const close_sidebar_menu = document.querySelector("aside .close-sidebar-btn");

if (side_menu_toggle) {
    side_menu_toggle.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.add("show");
        overlay.style.display = "block";
    })
}

if (close_sidebar_menu) {
    close_sidebar_menu.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.remove("show");
    });
}
if (overlay) {
    overlay.addEventListener("click", (e) => {
        sidebar.classList.remove("show");
        overlay.style.display = "none";
    });
}

// Show, hide password
const toggle_password_btns = document.querySelectorAll("i.toggle-password");

if (toggle_password_btns) {
    toggle_password_btns.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            btn.classList.toggle("fa-eye");
            btn.classList.toggle("fa-eye-slash");
            const element = btn.nextElementSibling;
            element.type = element.type === "password" ? "text" : "password";
        })
    });
}

// Swip on nav link Function
function swip_category(nav, first_container, second_container) {
    if (nav.classList.contains("active")) {
        first_container.classList.add("show");
        second_container.classList.remove("show");
    } else {
        first_container.classList.remove("show");
        second_container.classList.add("show");
    }
}

// income & expense categories
const income_nav = document.querySelector(".categories-section .income-nav");
const expense_nav = document.querySelector(".categories-section .expense-nav");
const income_categories_container = document.querySelector(".categories-section .income-categories-container")
const expenses_categories_container = document.querySelector(".categories-section .expense-categories-container")

// Swip categories
if (income_nav && expense_nav) {
    swip_category(income_nav, income_categories_container, expenses_categories_container);
    income_nav.addEventListener("click", (e) => {
        income_nav.classList.add("active");
        expense_nav.classList.remove("active");
        swip_category(income_nav, income_categories_container, expenses_categories_container);
    });

    expense_nav.addEventListener("click", (e) => {
        income_nav.classList.remove("active");
        expense_nav.classList.add("active");
        swip_category(income_nav, income_categories_container, expenses_categories_container);
    });
}

// Swip categoriy pie graph
const income_category_pie_nav = document.querySelector(".income-category-pie-nav");
const expense_category_pie_nav = document.querySelector(".expense-category-pie-nav");
const income_category_pie_container = document.querySelector(".income-category-pie-container");
const expense_category_pie_container = document.querySelector(".expense-category-pie-container");

if (income_category_pie_nav && expense_category_pie_nav) {
    swip_category(income_category_pie_nav, income_category_pie_container, expense_category_pie_container);
    income_category_pie_nav.addEventListener("click", (e) => {
        income_category_pie_nav.classList.add("active");
        expense_category_pie_nav.classList.remove("active");
        swip_category(income_category_pie_nav, income_category_pie_container, expense_category_pie_container);
    });

    expense_category_pie_nav.addEventListener("click", (e) => {
        income_category_pie_nav.classList.remove("active");
        expense_category_pie_nav.classList.add("active");
        swip_category(income_category_pie_nav, income_category_pie_container, expense_category_pie_container);
    });
}

function checkPasswordMatch(pwdField, confirmPwdField) {
    if (pwdField) {
        pwdField.addEventListener("focus", (e) => {
            e.preventDefault();
            const smallText = e.target.parentNode.querySelector("small");
            if (e.target.value.length < 6) {
                smallText.classList.add("minus");
                smallText.textContent = "At least 6 characters";
            }
            document.addEventListener("keyup", () => {
                if (e.target.value.length >= 6) {
                    smallText.classList.remove("minus");
                    smallText.textContent = "Enough";
                } else {
                    smallText.classList.add("minus");
                    smallText.textContent = "At least 6 characters";
                }
            });
        });
        pwdField.addEventListener("blur", (e) => {
            e.preventDefault();
            const smallText = pwdField.parentNode.querySelector("small");
            if (pwdField.value.length >= 6) {
                smallText.classList.remove("minus");
                smallText.textContent = "Enough";
            } else {
                smallText.classList.add("minus");
                smallText.textContent = "At least 6 characters";
            }
        })
    }

    if (confirmPwdField) {
        confirmPwdField.addEventListener("focus", (e) => {
            e.preventDefault();
            const pwd = pwdField.value;
            const smallText = e.target.parentNode.querySelector("small");
            smallText.classList.add("minus");
            document.addEventListener("keyup", () => {
                if (e.target.value == pwd) {
                    smallText.classList.remove("minus");
                    smallText.textContent = "Match";
                } else {
                    smallText.classList.add("minus");
                    smallText.textContent = "Password does't match";
                }
            });
        });
    }
}
//Password Match
const pwdField = document.querySelector(".register-section #password");
const confirmPwdField = document.querySelector(".register-section #confirmPassword");

checkPasswordMatch(pwdField, confirmPwdField);

const newPwdField = document.querySelector(".reset-password-section #new-password");
const confirmNewPwdField = document.querySelector(".reset-password-section #confirmPassword");

checkPasswordMatch(newPwdField, confirmNewPwdField);

const newPassword = document.querySelector(".change-password-section #new-password");
const confirmNewPassword = document.querySelector(".change-password-section #confirmPassword");

checkPasswordMatch(newPassword, confirmNewPassword);

// Select Icon
const icons = document.querySelectorAll(".icons-container i");
const selected_icon = document.querySelector(".add-categories-section #selected-icon i");
const icon_id = document.querySelector(".add-categories-section input#icon-id");

icons.forEach(icon => {
    icon.addEventListener("click", (e) => {
        e.preventDefault();
        const classArr = e.target.classList.value.split(" ");
        classArr.pop();
        classArr.pop();
        selected_icon.classList.value = classArr.join(" ");
        selected_icon.style.backgroundColor = e.target.style.backgroundColor;
        icon_id.value = e.target.dataset.id;
    })
});

// Alert hide
const alert = document.querySelector(".alert");

if (alert) {
    setTimeout(() => {
        alert.style.display = "none";
    }, 3000);
}

/*
    Input fields not filled, disable buttons
*/
// Login Page
let disableButtonLoginPage = () => {
    let btn = document.getElementById("btnsubmit");

    const email = document.getElementById("email");
    const password = document.getElementById("password");
    btn.disabled = email.value === "" || password.value.length < 6;

}

const loginInputFields = document.querySelectorAll(".login-section input");

if (loginInputFields) {
    loginInputFields.forEach(input => {
        disableButtonLoginPage(input);
    });
}

// Register Page
let disableButtonRegisterPage = () => {
    let btn = document.getElementById("btnsubmit");

    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    btn.disabled = username.value === "" || email.value === "" || password.value.length < 6 || password.value !== confirmPassword.value;

}

const registerInputFields = document.querySelectorAll(".register-section input");

if (registerInputFields) {
    registerInputFields.forEach(input => {
        disableButtonRegisterPage(input);
    });
}

// Profile upload
let disableButtonChangePassword = () => {
    let btn = document.getElementById("btnsubmit");

    const currentPassword = document.getElementById("current-password");
    const newPassword = document.getElementById("new-password");
    const confirmPassword = document.getElementById("confirmPassword");
    btn.disabled = currentPassword.value === "" || newPassword.value === "" || currentPassword.value.length < 6 || newPassword.value.length < 6 || newPassword.value !== confirmPassword.value;
}

const changePasswordFields = document.querySelectorAll(".change-password-section input");

if (changePasswordFields) {
    changePasswordFields.forEach(input => {
        disableButtonChangePassword(input);
    });
}

// Forgot Password, submit email
let disableButtonSubmitEmail = () => {
    let btn = document.getElementById("btnsubmit");

    const email = document.getElementById("email");
    btn.disabled = email.value === "";
}

const forgotPasswordsFields = document.querySelectorAll(".forgot-password-section input");

if (forgotPasswordsFields) {
    forgotPasswordsFields.forEach(input => {
        disableButtonSubmitEmail(input);
    });
}

// Reset Password
let disableButtonResetPassword = () => {
    let btn = document.getElementById("btnsubmit");

    const newPassword = document.getElementById("new-password");
    const confirmPassword = document.getElementById("confirmPassword");
    btn.disabled = newPassword.value.length < 6 || newPassword.value !== confirmPassword.value;
}

const resetPasswordsFields = document.querySelectorAll(".reset-password-section input");

if (resetPasswordsFields) {
    resetPasswordsFields.forEach(input => {
        disableButtonResetPassword(input);
    });
}

// Add budget
let disableButtonAddBudget = () => {
    let btn = document.getElementById("btnsubmit");

    const amount = document.getElementById("amount");
    btn.disabled = amount.value === "";
}

const addBudgetsFields = document.querySelectorAll(".add-budget-section input");

if (addBudgetsFields) {
    addBudgetsFields.forEach(input => {
        disableButtonAddBudget(input);
    });
}

const backToTopBtn = document.querySelector(".back-to-top");
if (backToTopBtn) {
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    }

    backToTopBtn.addEventListener("click", (e) => {
        e.preventDefault();
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
}
