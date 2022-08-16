const dropAreaAvatar = document.querySelector('.drag-area-avatar');
const dragTextAvatar = document.querySelector('.header-avatar');

let buttonAvatar = dropAreaAvatar.querySelector('.button-avatar');
let inputAvatar = document.querySelector('input#avatar');

let fileAvatar;

buttonAvatar.onclick = () => {
  inputAvatar.click();
};

// when browse
inputAvatar.addEventListener('change', function () {
  fileAvatar = this.files[0];
  dropAreaAvatar.classList.add('active');
  displayAvatarFile();
});

// when file is inside drag area
dropAreaAvatar.addEventListener('dragover', (event) => {
  event.preventDefault();
  dropAreaAvatar.classList.add('active');
  dragTextAvatar.textContent = 'Release to Upload';
  // console.log('File is inside the drag area');
});

// when file leave the drag area
dropAreaAvatar.addEventListener('dragleave', () => {
  dropAreaAvatar.classList.remove('active');
  // console.log('File left the drag area');
  dragTextAvatar.textContent = 'Drag & Drop';
});

// when file is dropped
dropAreaAvatar.addEventListener('drop', (event) => {
  event.preventDefault();
  // console.log('File is dropped in drag area');

  fileAvatar = event.dataTransfer.files[0]; // grab single file even of user selects multiple files

  // console.log(file);
  displayAvatarFile();
});

function displayAvatarFile() {
  let fileType = fileAvatar.type;
  // console.log(fileType);

  let validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];

  if (validExtensions.includes(fileType)) {
    // console.log('This is an image file');
    let fileReader = new FileReader();

    fileReader.onload = () => {
      let fileURL = fileReader.result;
      let imgTag = `<img src="${fileURL}" alt="">`;
      dropAreaAvatar.innerHTML = imgTag;
    };
    fileReader.readAsDataURL(fileAvatar);

    $("#avatar-save").removeClass("d-none");
    $("#avatar-save #btn-save").attr("type", "submit");
  } else {
    $("#errorImage").toast('show');
    dropAreaAvatar.classList.remove('active');

    $("#avatar-save").addClass("d-none");
    $("#avatar-save #btn-save").attr("type", "button");
  }
}




const dropAreaBanner = document.querySelector('.drag-area-banner');
const dragTextBanner = document.querySelector('.header-banner');

let buttonBanner = dropAreaBanner.querySelector('.button-banner');
let inputBanner = document.querySelector('input#banner');

let fileBanner;

buttonBanner.onclick = () => {
  inputBanner.click();
};

// when browse
inputBanner.addEventListener('change', function () {
  fileBanner = this.files[0];
  dropAreaBanner.classList.add('active');
  displayBannerFile();
});

// when file is inside drag area
dropAreaBanner.addEventListener('dragover', (event) => {
  event.preventDefault();
  dropAreaBanner.classList.add('active');
  dragTextBanner.textContent = 'Release to Upload';
  // console.log('File is inside the drag area');
});

// when file leave the drag area
dropAreaBanner.addEventListener('dragleave', () => {
  dropAreaBanner.classList.remove('active');
  // console.log('File left the drag area');
  dragTextBanner.textContent = 'Drag & Drop';
});

// when file is dropped
dropAreaBanner.addEventListener('drop', (event) => {
  event.preventDefault();
  // console.log('File is dropped in drag area');

  fileBanner = event.dataTransfer.files[0]; // grab single file even of user selects multiple files
  // console.log(file);
  displayBannerFile();
});

function displayBannerFile() {
  let fileType = fileBanner.type;
  // console.log(fileType);

  let validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];

  if (validExtensions.includes(fileType)) {
    // console.log('This is an image file');
    let fileReader = new FileReader();

    fileReader.onload = () => {
      let fileURL = fileReader.result;
      // console.log(fileURL);
      let imgTag = `<img src="${fileURL}" alt="">`;
      dropAreaBanner.innerHTML = imgTag;
    };
    fileReader.readAsDataURL(fileBanner);

    $("#banner-save").removeClass("d-none");
    $("#banner-save #btn-save").attr("type", "submit");
  } else {
    $("#errorImage").toast('show');
    dropAreaBanner.classList.remove('active');

    $("#banner-save").addClass("d-none");
    $("#banner-save #btn-save").attr("type", "button");
  }
}
