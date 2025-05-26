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
