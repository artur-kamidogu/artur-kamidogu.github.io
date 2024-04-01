document.getElementById('hot_price_switcher').addEventListener('click', function() {
    if (this.classList.contains('hot_price_switcher_active')) {
        this.classList.remove('hot_price_switcher_active');
    } else {
        this.classList.add('hot_price_switcher_active');
    }
});
