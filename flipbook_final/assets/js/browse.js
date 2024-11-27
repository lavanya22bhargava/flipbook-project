const browseBtn = document.getElementById('browseBtn');
const fileInput = document.getElementById('fileInput');
const fileInfo = document.getElementById('fileInfo');
const preview = document.getElementById('preview');
const uploadBtn = document.getElementById('uploadBtn');
const flipbookMessage = document.getElementById('flipbookMessage');
const flipbookContainer = document.getElementById('flipbookContainer');
const flipbookElement = document.getElementById('flipbook');

const pdfjsLib = window['pdfjs-dist/build/pdf'];

// Open file dialog when the button is clicked
browseBtn.addEventListener('click', () => {
    fileInput.click();
});

// Handle file input change
fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    preview.innerHTML = ""; // Clear previous previews

    if (files.length > 0) {
        let totalSize = 0;
        for (let file of files) {
            totalSize += file.size;
            if (totalSize > 100 * 1024 * 1024) {
                alert('Total file size exceeds 100MB. Please select smaller files.');
                fileInput.value = ''; // Clear file selection
                fileInfo.textContent = "No files selected.";
                uploadBtn.disabled = true;
                return;
            }

            // If the file is an image, preview it
            if (file.type.startsWith('image/')) {
                const filePreview = document.createElement('img');
                filePreview.classList.add('preview-image');
                filePreview.src = URL.createObjectURL(file);
                preview.appendChild(filePreview);
            } else if (file.type === "application/pdf") {
                // Handle PDF preview
                const pdfPreview = document.createElement('div');
                pdfPreview.textContent = `PDF: ${file.name}`;
                preview.appendChild(pdfPreview);
            }
        }
        fileInfo.textContent = `${files.length} file(s) selected.`;
        uploadBtn.disabled = false;
    } else {
        fileInfo.textContent = "No files selected.";
        uploadBtn.disabled = true;
    }
});

// Handle upload button click
uploadBtn.addEventListener('click', () => {
    // Simulate file upload and flipbook generation
    uploadBtn.disabled = true;
    fileInfo.textContent = "Uploading files...";
    flipbookMessage.classList.remove('hidden');

    const files = fileInput.files;
    let pdfFiles = [];
    let imageFiles = [];

    for (let file of files) {
        if (file.type === 'application/pdf') {
            pdfFiles.push(file);
        } else if (file.type.startsWith('image/')) {
            imageFiles.push(file);
        }
    }

    generateFlipbook(pdfFiles, imageFiles);
});

// Generate flipbook using Turn.js and PDF.js
function generateFlipbook(pdfFiles, imageFiles) {
    flipbookContainer.classList.remove('hidden');

    // Reset the flipbook element
    flipbookElement.innerHTML = '';

    // Add image files to flipbook
    imageFiles.forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('flip-page');
        flipbookElement.appendChild(img);
    });

    // Add PDF files to flipbook by converting each page into an image
    pdfFiles.forEach(pdfFile => {
        const reader = new FileReader();
        reader.onload = function() {
            const typedArray = new Uint8Array(this.result);
            pdfjsLib.getDocument(typedArray).promise.then(pdf => {
                const numPages = pdf.numPages;
                for (let i = 1; i <= numPages; i++) {
                    renderPDFPageToImage(pdf, i);
                }
            });
        };
        reader.readAsArrayBuffer(pdfFile);
    });

    // Initialize Turn.js for the flipbook
    $(flipbookElement).turn({
        width: 400,
        height: 300,
        autoCenter: true
    });
}

// Function to render a PDF page into an image
function renderPDFPageToImage(pdf, pageNumber) {
    pdf.getPage(pageNumber).then(page => {
        const scale = 1.5;
        const viewport = page.getViewport({scale: scale});

        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = viewport.width;
        canvas.height = viewport.height;

        // Render the PDF page into the canvas
        page.render({
            canvasContext: context,
            viewport: viewport
        }).promise.then(() => {
            // Once the page is rendered, convert the canvas to an image
            const img = new Image();
            img.src = canvas.toDataURL();
            img.classList.add('flip-page');
            flipbookElement.appendChild(img);

            // Initialize Turn.js after each page is loaded
            $(flipbookElement).turn({
                width: 400,
                height: 300,
                autoCenter: true
            });
        });
    });
}
