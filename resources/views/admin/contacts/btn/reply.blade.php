<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
      {{ trans('admin/template/common.text_reply') }}</button>






      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group my-modal-style">
                    <label for="recipient-name" class="col-form-label">To:</label>
                    <span class="email-to">mohammed@gmail.com</span>
                    {{-- <input type="text" class="form-control" id="recipient-name"> --}}
                  </div>
                  <div class="massage-content">Massage:
                   <p>this is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massagethis is test massage</p>
                  </div>
                
                <div class="form-group my-modal-style">
                  <label for="message-text" class="col-form-label">Reply:</label>
                  <textarea class="form-control" id="message-text"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Send message</button>
            </div>
          </div>
        </div>
      </div>