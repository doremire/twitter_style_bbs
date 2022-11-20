const but = document.getElementById('but');
const tweet_text = document.getElementById('commit').addEventListener('keyup', function (e) {
    if (e.target.value.length > 0) {
        but.style.opacity = "1";
        but.classList.add("opacity-but");
        but.disabled = false;
    } else {
        but.style.opacity = "0.5";
        but.classList.remove("opacity-but");
    }
});