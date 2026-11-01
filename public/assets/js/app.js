document.addEventListener('DOMContentLoaded', () => {
    const passwordToggles = document.querySelectorAll('[data-toggle-password]');
    passwordToggles.forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.togglePassword);
            if (!target) return;
            const isPassword = target.type === 'password';
            target.type = isPassword ? 'text' : 'password';
            button.textContent = isPassword ? 'Hide' : 'Show';
        });
    });

    const roleTabs = document.querySelectorAll('.role-tab');
    roleTabs.forEach((button) => {
        button.addEventListener('click', () => {
            roleTabs.forEach((tab) => tab.classList.toggle('active', tab === button));
            button.setAttribute('aria-pressed', String(button.classList.contains('active')));
        });
    });

    const faqItems = document.querySelectorAll('[data-faq-trigger]');
    faqItems.forEach((item) => {
        item.addEventListener('click', () => {
            const content = item.nextElementSibling;
            const isOpen = item.getAttribute('aria-expanded') === 'true';
            item.setAttribute('aria-expanded', String(!isOpen));
            if (content) {
                content.style.display = isOpen ? 'none' : 'block';
            }
        });
    });

    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    }

    const tabs = document.querySelectorAll('[data-tab-btn]');
    tabs.forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.dataset.tabBtn;
            tabs.forEach((btn) => btn.classList.toggle('active', btn === button));
            document.querySelectorAll('[data-tab-panel]').forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
            });
        });
    });

    const questionCards = document.querySelectorAll('.assessment-question');
    const prevButton = document.querySelector('[data-assessment-prev]');
    const nextButton = document.querySelector('[data-assessment-next]');
    const titleEl = document.getElementById('assessment-title');
    const progressEl = document.getElementById('assessment-progress');
    const formEl = document.getElementById('assessment-form');

    if (questionCards.length > 0 && titleEl && progressEl && formEl) {
        let currentIndex = 0;

        const updateQuestionState = () => {
            questionCards.forEach((card, index) => {
                const show = index === currentIndex;
                card.style.display = show ? '' : 'none';
            });

            const currentNumber = currentIndex + 1;
            const total = questionCards.length;
            titleEl.textContent = `Bagian ${currentNumber} dari ${total}`;
            progressEl.style.width = `${(currentNumber / total) * 100}%`;

            prevButton.disabled = currentIndex === 0;
            prevButton.style.opacity = currentIndex === 0 ? '0.55' : '1';
            nextButton.textContent = currentIndex === total - 1 ? 'Kirim Jawaban' : 'Selanjutnya';
        };

        prevButton.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex -= 1;
                updateQuestionState();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentIndex < questionCards.length - 1) {
                currentIndex += 1;
                updateQuestionState();
                return;
            }

            formEl.submit();
        });

        updateQuestionState();
    }
});
