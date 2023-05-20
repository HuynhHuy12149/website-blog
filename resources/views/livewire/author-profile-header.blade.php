<div>
    <div class="page-header">
  <div class="row align-items-center">
    <div class="col-auto">
      <span class="avatar avatar-md" style="background-image: url({{ $author->picture }})"></span>
    </div>
    <div class="col-md-6">
      <h2 class="page-title">{{ $author->name }}</h2>
      <div class="page-subtitle">
        <div class="row">
          <div class="col-auto">
            <a href="#" class="text-reset">@ {{ $author->username }} | {{ $author->authorType->name }}</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-auto d-md-flex">
      <input type="file" class="d-none" name='file' id='changeAuthorPictureFile' onchange="this.dispatchEvent(new InputEvent('input'))">
      <a href="#" class="btn btn-primary" onclick="event.preventDefault();document.getElementById('changeAuthorPictureFile').click();">
        <!-- Download SVG icon from http://tabler-icons.io/i/message -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M15 8h.01"></path>
          <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
          <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
          <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
       </svg>
        Thay đổi hình ảnh
      </a>
    </div>
  </div>
</div>


</div>
