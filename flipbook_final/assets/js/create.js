const pdfFileInput = document.getElementById('pdfFile');
const generateFlipbookBtn = document.getElementById('generateFlipbook');
const flipbookContainer = document.getElementById('flipbook');
const prevPageBtn = document.getElementById('prevPage');
const nextPageBtn = document.getElementById('nextPage');

// Variables to track pages and current state
let pages = [];
let currentIndex = 0;

// Load the selected PDF
pdfFileInput.addEventListener('change', () => {
  generateFlipbookBtn.disabled = !pdfFileInput.files.length;
});

// Generate flipbook
generateFlipbookBtn.addEventListener('click', async () => {
  const file = pdfFileInput.files[0];
  if (!file) return;

  const fileReader = new FileReader();
  fileReader.onload = async (e) => {
    const pdfData = new Uint8Array(e.target.result);
    const pdf = await pdfjsLib.getDocument(pdfData).promise;

    flipbookContainer.innerHTML = '';
    pages = [];
    currentIndex = 0;

    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
      const page = await pdf.getPage(pageNum);
      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');
      const viewport = page.getViewport({ scale: 1.5 });

      canvas.width = viewport.width;
      canvas.height = viewport.height;

      await page.render({ canvasContext: context, viewport }).promise;

      const img = document.createElement('img');
      img.src = canvas.toDataURL();
      img.alt = `Page ${pageNum}`;

      const pageDiv = document.createElement('div');
      pageDiv.className = 'flipbook-page';
      pageDiv.appendChild(img);

      pages.unshift(pageDiv); // Add to start for reverse flipping
      flipbookContainer.appendChild(pageDiv);
    }

    // Initialize the flipbook display
    updateFlipbook();
    updateNavigationButtons();
  };

  fileReader.readAsArrayBuffer(file);
});

// Update flipbook to show the current page
function updateFlipbook() {
  pages.forEach((page, index) => {
    page.style.zIndex = pages.length - index;
    page.classList.remove('flipped');
    if (index < currentIndex) {
      page.classList.add('flipped');
    }
  });
}

// Navigation buttons
prevPageBtn.addEventListener('click', () => {
  if (currentIndex > 0) {
    currentIndex--;
    updateFlipbook();
    updateNavigationButtons();
  }
});

nextPageBtn.addEventListener('click', () => {
  if (currentIndex < pages.length - 1) {
    currentIndex++;
    updateFlipbook();
    updateNavigationButtons();
  }
});

// Enable or disable navigation buttons based on the current page
function updateNavigationButtons() {
  prevPageBtn.disabled = currentIndex === 0;
  nextPageBtn.disabled = currentIndex === pages.length - 1;
}

document.getElementById('generateFlipbook').addEventListener('click', function () {
    // Logic for generating flipbook...
  
    // Enable the "Save Flipbook" button after the flipbook is generated
    document.getElementById('saveFlipbook').disabled = false;
  
    // Collect flipbook data (e.g., images of pages as base64)
    const flipbookPages = document.querySelectorAll('.flipbook-page img');
    const flipbookData = [];
    flipbookPages.forEach((img) => {
      flipbookData.push(img.src);
    });
  
    // Set hidden form field values
    document.getElementById('flipbookData').value = JSON.stringify(flipbookData);
  });
  