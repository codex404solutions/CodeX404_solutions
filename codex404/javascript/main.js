// MOBILE MENU TOGGLE
const menuToggle = document.getElementById("menuToggle");
const nav = document.querySelector(".nav");

menuToggle.addEventListener("click", () => {
    nav.classList.toggle("active");
});

// SCROLL ANIMATION
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = 1;
            entry.target.style.transform = "translateY(0)";
        }
    });
}, { threshold: 0.15 });

document.querySelectorAll("section, .service-card").forEach(el => {
    el.style.opacity = 0;
    el.style.transform = "translateY(40px)";
    el.style.transition = "0.8s ease";
    observer.observe(el);
});


// CONTACT TABS
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

        btn.classList.add('active');
        document.getElementById(btn.dataset.tab).classList.add('active');
    });
});


// AUTO HIDE SUCCESS MESSAGE AFTER 5 SECONDS
document.addEventListener("DOMContentLoaded", function () {
    const successMsg = document.querySelector(".auto-hide");

    if (successMsg) {
        setTimeout(() => {
            successMsg.classList.add("hide");
        }, 5000);
    }
});


// PORTFOLIO FILTER
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {

        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.dataset.filter;

        document.querySelectorAll('.portfolio-card').forEach(card => {
            if (filter === 'all' || card.classList.contains(filter)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});


// Fade-in on scroll
const fadeElements = document.querySelectorAll('.fade-in');

const fadeInObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                fadeInObserver.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.2 }
);

fadeElements.forEach(el => fadeInObserver.observe(el));




// Hero animation on load
window.addEventListener('load', () => {
    const hero = document.querySelector('.hero');
    if (hero) hero.classList.add('animate');
});


// Page fade-in transition
window.addEventListener('DOMContentLoaded', () => {
    document.body.classList.add('page-loaded');
});
