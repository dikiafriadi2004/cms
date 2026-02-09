// ========================================
// QUILL IMAGE RESIZE FUNCTIONALITY
// ========================================
(function() {
    let selectedImage = null;
    let resizer = null;
    let toolbar = null;
    let startX, startY, startWidth, startHeight;
    let quillEditor = null;

    // Initialize when DOM is ready
    function init(editor) {
        quillEditor = editor;
        createResizer();
        createToolbar();
        attachEventListeners();
    }

    // Create resizer element
    function createResizer() {
        resizer = document.createElement('div');
        resizer.className = 'image-resizer';
        resizer.innerHTML = `
            <div class="handle handle-nw"></div>
            <div class="handle handle-ne"></div>
            <div class="handle handle-sw"></div>
            <div class="handle handle-se"></div>
        `;
        document.body.appendChild(resizer);
        
        // Add resize handlers
        resizer.querySelectorAll('.handle').forEach(handle => {
            handle.addEventListener('mousedown', startResize);
        });
    }

    // Create toolbar
    function createToolbar() {
        toolbar = document.createElement('div');
        toolbar.className = 'image-toolbar';
        toolbar.innerHTML = `
            <button onclick="window.QuillImageResize.resizeImage('small')" title="Small (300px)">Small</button>
            <button onclick="window.QuillImageResize.resizeImage('medium')" title="Medium (600px)">Medium</button>
            <button onclick="window.QuillImageResize.resizeImage('large')" title="Large (100%)">Large</button>
            <button onclick="window.QuillImageResize.alignImage('left')" title="Align Left">← Left</button>
            <button onclick="window.QuillImageResize.alignImage('center')" title="Align Center">Center</button>
            <button onclick="window.QuillImageResize.alignImage('right')" title="Align Right">Right →</button>
            <button onclick="window.QuillImageResize.removeImage()" title="Remove" style="color: #e53e3e;">✕ Remove</button>
        `;
        document.body.appendChild(toolbar);
    }

    // Attach event listeners
    function attachEventListeners() {
        if (!quillEditor || !quillEditor.root) return;

        // Handle image click
        quillEditor.root.addEventListener('click', function(e) {
            if (e.target.tagName === 'IMG') {
                selectImage(e.target);
            } else {
                deselectImage();
            }
        });

        // Deselect on click outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.ql-editor') && 
                !e.target.closest('.image-resizer') && 
                !e.target.closest('.image-toolbar')) {
                deselectImage();
            }
        });

        // Update resizer position on scroll
        window.addEventListener('scroll', function() {
            if (selectedImage) {
                selectImage(selectedImage);
            }
        });
    }

    // Select image
    function selectImage(img) {
        selectedImage = img;
        const rect = img.getBoundingClientRect();
        
        // Position resizer
        resizer.style.top = rect.top + window.scrollY + 'px';
        resizer.style.left = rect.left + window.scrollX + 'px';
        resizer.style.width = rect.width + 'px';
        resizer.style.height = rect.height + 'px';
        resizer.classList.add('active');
        
        // Position toolbar
        toolbar.style.top = (rect.top + window.scrollY - 45) + 'px';
        toolbar.style.left = rect.left + window.scrollX + 'px';
        toolbar.classList.add('active');
    }

    // Deselect image
    function deselectImage() {
        selectedImage = null;
        if (resizer) resizer.classList.remove('active');
        if (toolbar) toolbar.classList.remove('active');
    }

    // Start resize
    function startResize(e) {
        e.preventDefault();
        if (!selectedImage) return;
        
        startX = e.clientX;
        startY = e.clientY;
        startWidth = selectedImage.offsetWidth;
        startHeight = selectedImage.offsetHeight;
        
        document.addEventListener('mousemove', doResize);
        document.addEventListener('mouseup', stopResize);
    }

    // Do resize
    function doResize(e) {
        if (!selectedImage || !quillEditor) return;
        
        const deltaX = e.clientX - startX;
        let newWidth = startWidth + deltaX;
        
        // Min/max constraints
        newWidth = Math.max(100, Math.min(newWidth, quillEditor.root.offsetWidth));
        
        selectedImage.style.width = newWidth + 'px';
        selectedImage.style.height = 'auto';
        
        // Update resizer
        const rect = selectedImage.getBoundingClientRect();
        resizer.style.width = rect.width + 'px';
        resizer.style.height = rect.height + 'px';
    }

    // Stop resize
    function stopResize() {
        document.removeEventListener('mousemove', doResize);
        document.removeEventListener('mouseup', stopResize);
    }

    // Resize image to preset size
    function resizeImageToSize(size) {
        if (!selectedImage) return;
        
        selectedImage.classList.remove('ql-image-small', 'ql-image-medium', 'ql-image-large');
        selectedImage.style.width = '';
        selectedImage.style.height = '';
        
        if (size === 'small') {
            selectedImage.classList.add('ql-image-small');
            selectedImage.style.width = '300px';
        } else if (size === 'medium') {
            selectedImage.classList.add('ql-image-medium');
            selectedImage.style.width = '600px';
        } else if (size === 'large') {
            selectedImage.classList.add('ql-image-large');
            selectedImage.style.width = '100%';
        }
        
        selectImage(selectedImage);
    }

    // Align image
    function alignImageTo(alignment) {
        if (!selectedImage) return;
        
        selectedImage.style.display = 'block';
        if (alignment === 'left') {
            selectedImage.style.marginLeft = '0';
            selectedImage.style.marginRight = 'auto';
        } else if (alignment === 'center') {
            selectedImage.style.marginLeft = 'auto';
            selectedImage.style.marginRight = 'auto';
        } else if (alignment === 'right') {
            selectedImage.style.marginLeft = 'auto';
            selectedImage.style.marginRight = '0';
        }
    }

    // Remove image
    function removeSelectedImage() {
        if (!selectedImage) return;
        
        if (confirm('Remove this image?')) {
            selectedImage.remove();
            deselectImage();
        }
    }

    // Export public API
    window.QuillImageResize = {
        init: init,
        resizeImage: resizeImageToSize,
        alignImage: alignImageTo,
        removeImage: removeSelectedImage
    };
})();
