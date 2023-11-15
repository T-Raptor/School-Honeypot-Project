const imgbb_api_key = 'ae68f09e0d0cfbc38ee7fad613de005b';

function isValidImageType(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Add more types if needed
    return allowedTypes.includes(file.type);
}

function isValidImageSize(file) {
    const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB, adjust as needed
    return file.size <= maxSizeInBytes;
}

function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function resizeImage(img, width, height, quality) {
    return new Promise((resolve) => {
        const canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);
        canvas.toBlob((blob) => resolve(blob), 'image/jpeg', quality);
    });
}

function uploadImage(resizedBlob, email) {
    const formData = new FormData();
    formData.append('key', imgbb_api_key);
    formData.append('image', resizedBlob);
    formData.append('name', email);

    return fetch('https://api.imgbb.com/1/upload', {
        method: 'POST',
        body: formData,
    })
    .then((response) => response.json())
    .then((result) => {
        if (result.success) {
            return result.data.url;
        } else {
            throw new Error('Image upload failed.');
        }
    });
}

function resizeAndUploadImage() {
    const fileInput = document.querySelector('#avatar');
    const emailInput = document.querySelector('#email');

    const file = fileInput.files[0];

    if (!emailIsValid(emailInput.value)) {
        alert('Invalid email address.');
        return;
    }

    if (!file) { document.querySelector('#registrationForm').submit(); }

    // Validate image type
    if (!isValidImageType(file)) {
        alert('Invalid image type. Please upload a JPEG, PNG, or GIF.');
        return;
    }

    // Validate image size
    if (!isValidImageSize(file)) {
        alert('Image size exceeds the allowed limit (5 MB). Please choose a smaller image.');
        return;
    }

    const img = new Image();
    img.src = URL.createObjectURL(file);

    img.onload = function () {
        const width = 256; // Adjust the dimensions as needed
        const height = 256;
        const quality = 0.75;

        resizeImage(img, width, height, quality)
            .then((resizedBlob) => {
                const salt = Math.random().toString(36).substring(2, 5); // Generate random string for unique filename
                const email = emailInput.value; // Get the user's email

                const fileName = email + '_' + salt;

                return uploadImage(resizedBlob, fileName);
            })
            .then((imageURL) => {
                // Save the ImgBB URL in a hidden input field
                const imgbbInput = document.querySelector('#img_url');
                imgbbInput.value = imageURL;

                URL.revokeObjectURL(img.src);

                fileInput.value = ''; // Clear the input field so nginx does not give erro 413

                document.querySelector('#registrationForm').submit();

            })
            .catch((error) => {
                alert(error.message);
            });
    };
}

document.querySelector('#registerButton').addEventListener('click', resizeAndUploadImage);
