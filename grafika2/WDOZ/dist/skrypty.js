     // Pobieramy wszystkie przyciski z klasą plus i minus
     document.querySelectorAll('.plus').forEach(button => {
        button.addEventListener('click', () => {
            // Znajdujemy sąsiadujące pole input z klasą price
            const input = button.previousElementSibling;
            if (input && input.classList.contains('price')) {
                input.value = parseInt(input.value, 10) + 1;
            }
        });
    });

    document.querySelectorAll('.minus').forEach(button => {
        button.addEventListener('click', () => {
            // Znajdujemy sąsiadujące pole input z klasą price
            const input = button.nextElementSibling;
            if (input && input.classList.contains('price')) {
                const currentValue = parseInt(input.value, 10);
                if (currentValue > 0) {
                    input.value = currentValue - 1;
                }
            }
        });
    });