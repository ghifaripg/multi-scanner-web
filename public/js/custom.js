// document.addEventListener("DOMContentLoaded", function () {
//     // ================================
//     //  File Upload and Scan Handling
//     // ================================
//     const uploadBoxes = document.querySelectorAll(".uploadBox");
//     const scanButton = document.querySelector(".btn-scan");
//     const scanForm = document.querySelector("form");

//     if (!scanButton || !scanForm) {
//         console.error("❌ scanButton or scanForm not found in the page.");
//         return;
//     }

//     uploadBoxes.forEach((uploadBox) => {
//         const fileInput = uploadBox.querySelector(".fileInput");
//         const uploadText = uploadBox.querySelector(".uploadText");
//         const fileSelected = uploadBox.querySelector(".fileSelected");
//         const fileName = uploadBox.querySelector(".fileName");
//         const removeFileBtn = uploadBox.querySelector(".removeFileBtn");

//         uploadBox.addEventListener("click", (e) => {
//             if (!removeFileBtn || e.target !== removeFileBtn) {
//                 fileInput.click();
//             }
//         });

//         fileInput.addEventListener("change", () => {
//             if (fileInput.files.length > 0) {
//                 handleFileUpload(
//                     fileInput.files[0],
//                     uploadText,
//                     fileSelected,
//                     fileName
//                 );

//                 scanButton.disabled = false;
//                 scanButton.classList.remove("btn-disabled");
//             }
//         });

//         uploadBox.addEventListener("dragover", (e) => {
//             e.preventDefault();
//             uploadBox.classList.add("drag-active");
//         });

//         uploadBox.addEventListener("dragleave", () => {
//             uploadBox.classList.remove("drag-active");
//         });

//         uploadBox.addEventListener("drop", (e) => {
//             e.preventDefault();
//             uploadBox.classList.remove("drag-active");

//             if (e.dataTransfer.files.length > 0) {
//                 fileInput.files = e.dataTransfer.files;
//                 handleFileUpload(
//                     e.dataTransfer.files[0],
//                     uploadText,
//                     fileSelected,
//                     fileName
//                 );

//                 scanButton.disabled = false;
//                 scanButton.classList.remove("btn-disabled");
//             }
//         });

//         function handleFileUpload(file, uploadText, fileSelected, fileName) {
//             if (!file) return;

//             fileName.textContent = file.name;
//             uploadText.classList.add("d-none");
//             fileSelected.classList.remove("d-none");
//         }

//         if (removeFileBtn) {
//             removeFileBtn.addEventListener("click", (e) => {
//                 e.stopPropagation();
//                 fileInput.value = "";
//                 fileName.textContent = "";
//                 uploadText.classList.remove("d-none");
//                 fileSelected.classList.add("d-none");

//                 scanButton.disabled = true;
//                 scanButton.classList.add("btn-disabled");
//             });
//         }
//     });

//     scanButton.addEventListener("click", function (e) {
//         e.preventDefault();

//         const fileInputs = document.querySelectorAll(".fileInput");
//         let hasFile = false;

//         fileInputs.forEach((input) => {
//             if (input.files.length > 0) {
//                 hasFile = true;
//             }
//         });

//         if (!hasFile) {
//             alert("⚠️ Please select a file before scanning!");
//             return;
//         }

//         console.log("⏳ Scanning file started...");

//         fetch(scanForm.action, {
//             method: "POST",
//             body: new FormData(scanForm),
//         })
//             .then((response) => response.json())
//             .then((data) => {
//                 console.log("✅ Scanning completed!");
//                 window.location.href = data.redirect;
//             })
//             .catch((error) => {
//                 console.error("❌ Error scanning:", error);
//                 alert("Scanning failed. Please try again.");
//             });
//     });

//     // ================================
//     //  Comment Modal (Draggable)
//     // ================================
//     const commentBtns = document.querySelectorAll(".comment-btn");
//     const modal = document.getElementById("commentModal");
//     const closeBtn = document.querySelector(".close");
//     const cancelBtn = document.getElementById("cancelComment");

//     commentBtns.forEach((btn) => {
//         btn.addEventListener("click", () => modal.style.display = "block");
//     });

//     closeBtn.addEventListener("click", () => modal.style.display = "none");
//     cancelBtn.addEventListener("click", () => modal.style.display = "none");

//     let isDragging = false, offsetX = 0, offsetY = 0;

//     modal.addEventListener("mousedown", (e) => {
//         isDragging = true;
//         offsetX = e.clientX - modal.offsetLeft;
//         offsetY = e.clientY - modal.offsetTop;
//     });

//     document.addEventListener("mousemove", (e) => {
//         if (isDragging) {
//             modal.style.left = `${e.clientX - offsetX}px`;
//             modal.style.top = `${e.clientY - offsetY}px`;
//         }
//     });

//     document.addEventListener("mouseup", () => isDragging = false);
// });

//Email dropbox previous
// document.addEventListener('DOMContentLoaded', function() {
//     // DOM Elements
//     const fileInput = document.querySelector('.fileInput');
//     const uploadBox = document.querySelector('.uploadBox');
//     const uploadText = document.querySelector('.uploadText');
//     const fileSelected = document.querySelector('.fileSelected');
//     const fileName = document.querySelector('.fileName');
//     const removeFileBtn = document.querySelector('.removeFileBtn');
//     const scanBtn = document.getElementById('scanBtn');
//     const form = document.querySelector('form');

//     // 1. Trigger file input when clicking the upload box
//     uploadBox.addEventListener('click', function(e) {
//         // Don't trigger if clicking on remove button
//         if (!e.target.classList.contains('btn-remove')) {
//             fileInput.click();
//         }
//     });

//     // 2. Handle file selection
//     fileInput.addEventListener('change', function(e) {
//         if (e.target.files.length > 0) {
//             const file = e.target.files[0];
//             if (validateFile(file)) {
//                 updateFileDisplay(file.name);
//             }
//         }
//     });

//     // 3. Handle drag and drop
//     ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, preventDefaults, false);
//     });

//     function preventDefaults(e) {
//         e.preventDefault();
//         e.stopPropagation();
//     }

//     ['dragenter', 'dragover'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, highlight, false);
//     });

//     ['dragleave', 'drop'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, unhighlight, false);
//     });

//     function highlight() {
//         uploadBox.classList.add('dragover');
//     }

//     function unhighlight() {
//         uploadBox.classList.remove('dragover');
//     }

//     uploadBox.addEventListener('drop', function(e) {
//         const dt = e.dataTransfer;
//         const file = dt.files[0];
        
//         if (file && validateFile(file)) {
//             fileInput.files = dt.files;
//             updateFileDisplay(file.name);
//         }
//     });

//     // 4. Remove file
//     removeFileBtn.addEventListener('click', function(e) {
//         e.stopPropagation();
//         resetFileDisplay();
//     });

//     // 5. Form submission handling
//     form.addEventListener('submit', function(e) {
//         if (!fileInput.files.length) {
//             e.preventDefault();
//             alert('Please select an .eml file first');
//         }
//     });

//     // Helper functions
//     function validateFile(file) {
//         // Check file type
//         if (!file.name.endsWith('.eml')) {
//             alert('Only .eml files are allowed');
//             return false;
//         }
        
//         // Check file size (10MB max)
//         if (file.size > 1024 * 1024 * 10) {
//             alert('File size must be less than 10MB');
//             return false;
//         }
        
//         return true;
//     }

//     function updateFileDisplay(name) {
//         uploadText.classList.add('d-none');
//         fileSelected.classList.remove('d-none');
//         fileName.textContent = name;
//         scanBtn.disabled = false;
//         scanBtn.classList.remove('btn-disabled');
//     }

//     function resetFileDisplay() {
//         fileInput.value = '';
//         uploadText.classList.remove('d-none');
//         fileSelected.classList.add('d-none');
//         fileName.textContent = '';
//         scanBtn.disabled = true;
//         scanBtn.classList.add('btn-disabled');
//     }
// });

/* ===============================
   Email File Upload (.eml)
   =============================== */
// document.addEventListener('DOMContentLoaded', function () {
//     const emailForm = document.querySelector('form.emailForm');
//     if (!emailForm) return;

//     const fileInput = emailForm.querySelector('.fileInput');
//     const uploadBox = emailForm.querySelector('.uploadBox');
//     const uploadText = emailForm.querySelector('.uploadText');
//     const fileSelected = emailForm.querySelector('.fileSelected');
//     const fileName = emailForm.querySelector('.fileName');
//     const removeFileBtn = emailForm.querySelector('.removeFileBtn');
//     const scanBtn = emailForm.querySelector('#scanBtn');

//     uploadBox.addEventListener('click', function (e) {
//         if (!e.target.classList.contains('btn-remove')) {
//             fileInput.click();
//         }
//     });

//     fileInput.addEventListener('change', function (e) {
//         const file = e.target.files[0];
//         if (file && validateEmailFile(file)) {
//             updateFileDisplay(file.name);
//         }
//     });

//     ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, preventDefaults, false);
//     });

//     ['dragenter', 'dragover'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, () => uploadBox.classList.add('dragover'), false);
//     });

//     ['dragleave', 'drop'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, () => uploadBox.classList.remove('dragover'), false);
//     });

//     uploadBox.addEventListener('drop', function (e) {
//         const file = e.dataTransfer.files[0];
//         if (file && validateEmailFile(file)) {
//             fileInput.files = e.dataTransfer.files;
//             updateFileDisplay(file.name);
//         }
//     });

//     removeFileBtn.addEventListener('click', function (e) {
//         e.stopPropagation();
//         resetFileDisplay();
//     });

//     emailForm.addEventListener('submit', function (e) {
//         if (!fileInput.files.length) {
//             e.preventDefault();
//             alert('Please select an .eml file first');
//         }
//     });

//     function preventDefaults(e) {
//         e.preventDefault();
//         e.stopPropagation();
//     }

//     function validateEmailFile(file) {
//         if (!file.name.endsWith('.eml')) {
//             alert('Only .eml files are allowed');
//             return false;
//         }
//         if (file.size > 10 * 1024 * 1024) {
//             alert('File size must be less than 10MB');
//             return false;
//         }
//         return true;
//     }

//     function updateFileDisplay(name) {
//         uploadText.classList.add('d-none');
//         fileSelected.classList.remove('d-none');
//         fileName.textContent = name;
//         scanBtn.disabled = false;
//         scanBtn.classList.remove('btn-disabled');
//     }

//     function resetFileDisplay() {
//         fileInput.value = '';
//         uploadText.classList.remove('d-none');
//         fileSelected.classList.add('d-none');
//         fileName.textContent = '';
//         scanBtn.disabled = true;
//         scanBtn.classList.add('btn-disabled');
//     }
// });


// /* ===============================
//    File Upload (.exe, .pdf)
//    =============================== */
// document.addEventListener('DOMContentLoaded', function () {
//     const fileForm = document.querySelector('form.exeForm');
//     if (!fileForm) return;

//     const fileInput = fileForm.querySelector('.fileInput');
//     const uploadBox = fileForm.querySelector('.uploadBox');
//     const uploadText = fileForm.querySelector('.uploadText');
//     const fileSelected = fileForm.querySelector('.fileSelected');
//     const fileName = fileForm.querySelector('.fileName');
//     const removeFileBtn = fileForm.querySelector('.removeFileBtn');
//     const scanBtn = fileForm.querySelector('#scanBtn');

//     uploadBox.addEventListener('click', function (e) {
//         if (!e.target.classList.contains('btn-remove')) {
//             fileInput.click();
//         }
//     });

//     fileInput.addEventListener('change', function (e) {
//         const file = e.target.files[0];
//         if (file && validateFile(file)) {
//             updateFileDisplay(file.name);
//         }
//     });

//     ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, preventDefaults, false);
//     });

//     ['dragenter', 'dragover'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, () => uploadBox.classList.add('dragover'), false);
//     });

//     ['dragleave', 'drop'].forEach(eventName => {
//         uploadBox.addEventListener(eventName, () => uploadBox.classList.remove('dragover'), false);
//     });

//     uploadBox.addEventListener('drop', function (e) {
//         const file = e.dataTransfer.files[0];
//         if (file && validateFile(file)) {
//             fileInput.files = e.dataTransfer.files;
//             updateFileDisplay(file.name);
//         }
//     });

//     removeFileBtn.addEventListener('click', function (e) {
//         e.stopPropagation();
//         resetFileDisplay();
//     });

//     fileForm.addEventListener('submit', function (e) {
//         if (!fileInput.files.length) {
//             e.preventDefault();
//             alert('Please select a .exe or .pdf file first');
//         }
//     });

//     function preventDefaults(e) {
//         e.preventDefault();
//         e.stopPropagation();
//     }

//     function validateFile(file) {
//         const allowed = ['.exe', '.pdf'];
//         const isValid = allowed.some(ext => file.name.endsWith(ext));
//         if (!isValid) {
//             alert('Only .exe and .pdf files are allowed');
//             return false;
//         }
//         if (file.size > 10 * 1024 * 1024) {
//             alert('File size must be less than 10MB');
//             return false;
//         }
//         return true;
//     }

//     function updateFileDisplay(name) {
//         uploadText.classList.add('d-none');
//         fileSelected.classList.remove('d-none');
//         fileName.textContent = name;
//         scanBtn.disabled = false;
//         scanBtn.classList.remove('btn-disabled');
//     }

//     function resetFileDisplay() {
//         fileInput.value = '';
//         uploadText.classList.remove('d-none');
//         fileSelected.classList.add('d-none');
//         fileName.textContent = '';
//         scanBtn.disabled = true;
//         scanBtn.classList.add('btn-disabled');
//     }
// });
