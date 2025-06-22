// Confirmação de exclusão
document.addEventListener('DOMContentLoaded', function() {
    // Confirmação para formulários de exclusão
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const confirmMessage = this.dataset.confirm || 'Tem certeza que deseja excluir este item?';
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        });
    });

    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Preview de imagem no upload
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove preview anterior se existir
                    const existingPreview = input.parentNode.querySelector('.image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }

                    // Cria novo preview
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <p class="image-label">Preview:</p>
                        <img src="${e.target.result}" alt="Preview" class="current-image-preview">
                    `;
                    input.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Smooth scroll para âncoras
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N para nova tarefa
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            const newTaskBtn = document.querySelector('a[href*="tasks/create"]');
            if (newTaskBtn) {
                window.location.href = newTaskBtn.href;
            }
        }

        // Escape para voltar
        if (e.key === 'Escape') {
            const backBtn = document.querySelector('.btn[href*="index"]');
            if (backBtn) {
                window.location.href = backBtn.href;
            }
        }
    });

    // Loading state para formulários
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
            }
        });
    });

    // Tooltip simples
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.title;
            tooltip.style.cssText = `
                position: absolute;
                background: #1e293b;
                color: white;
                padding: 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.75rem;
                z-index: 1000;
                pointer-events: none;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            `;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            
            this.removeAttribute('title');
            this.dataset.originalTitle = tooltip.textContent;
        });

        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) {
                tooltip.remove();
            }
            if (this.dataset.originalTitle) {
                this.title = this.dataset.originalTitle;
                delete this.dataset.originalTitle;
            }
        });
    });
});

// Função para filtros dinâmicos
function updateFilters() {
    const form = document.querySelector('.filters-form');
    if (form) {
        form.submit();
    }
}

// Função para toggle de status via AJAX (opcional)
function toggleTaskStatus(taskId) {
    fetch(`/tasks/${taskId}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}