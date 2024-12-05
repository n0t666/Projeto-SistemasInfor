
function previewImage(event, imgId, inputId, removeId, addId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(imgId).src = e.target.result;
            document.getElementById(removeId).style.display = 'block';
            document.getElementById(addId).style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

function removeProfile() {
    document.getElementById('profile-img-preview').src = originalProfileImage;
    document.getElementById('remove-profile').style.display = 'none';
    document.getElementById('add-profile').style.display = 'block';
}

function removeCover() {
    document.getElementById('cover-img-preview').src = originalCoverImage;
    document.getElementById('remove-cover').style.display = 'none';
    document.getElementById('add-cover').style.display = 'block';
}