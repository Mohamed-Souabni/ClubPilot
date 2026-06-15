document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-logo-upload]').forEach((uploader) => {
        const input = uploader.querySelector('[data-logo-input]');
        const button = uploader.querySelector('[data-logo-button]');
        const dropzone = uploader.querySelector('[data-logo-dropzone]');
        const preview = uploader.querySelector('[data-logo-preview]');

        if (! input || ! button || ! dropzone || ! preview) {
            return;
        }

        const setLogoFile = (file) => {
            if (! file || ! file.type.startsWith('image/')) {
                return;
            }

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;

            const imageUrl = URL.createObjectURL(file);
            preview.innerHTML = '';

            const image = document.createElement('img');
            image.src = imageUrl;
            image.alt = 'Apercu du logo';
            preview.appendChild(image);

            dropzone.classList.add('has-file');
        };

        button.addEventListener('click', (event) => {
            event.preventDefault();
            input.click();
        });

        input.addEventListener('change', () => {
            setLogoFile(input.files?.[0]);
        });

        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('is-dragging');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('is-dragging');
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('is-dragging');
            setLogoFile(event.dataTransfer.files?.[0]);
        });

        dropzone.addEventListener('paste', (event) => {
            const items = Array.from(event.clipboardData?.items || []);
            const imageItem = items.find((item) => item.type.startsWith('image/'));

            if (imageItem) {
                event.preventDefault();
                setLogoFile(imageItem.getAsFile());
            }
        });
    });
});
