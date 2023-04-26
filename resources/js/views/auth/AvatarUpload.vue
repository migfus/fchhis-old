<template>
  <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">Change Avatar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <VuePictureCropper :boxStyle="cropperBoxStyle" :img="pic" :options="cropperOption" />

          <div class="form-group">
            <label for="formFile" class="form-label mt-2">Upload Image</label>
            <div class="custom-file">
              <input ref="uploadInput" type="file" class="custom-file-input" id="customFile"
                accept="image/jpg, image/jpeg, image/png, image/gif" @change="SelectFile">
              <label class="custom-file-label" for="customFile">Choose local file</label>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" @click="Reset">Reset</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="GetResult">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { ref } from 'vue';
import { useRegisterStore } from '@/store/auth/register'

const $register = useRegisterStore();

const uploadInput = ref(null);
const pic = ref('')
const cropperOption = {
  viewMode: 2,
  dragMode: 'crop',
  aspectRatio: 1,
}
const cropperBoxStyle = {
  width: '100%',
  height: '100%',
  backgroundColor: '#f8f8f8',
  margin: 'auto',
}

function SelectFile(event) {
  pic.value = '';

  const { files } = event.target
  if (!files || !files.length) return

  const file = files[0]
  const reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onload = () => {
    pic.value = String(reader.result)
    if (!uploadInput.value) return
    uploadInput.value.value = ''
  }
}

async function GetResult() {
  if (!cropper) return
  const base64 = cropper.getDataURL({
    maxWidth: 200,
    maxHeight: 200,
    imageSmoothingQuality: 'high'
  })

  UploadImage(base64)
}

function UploadImage(file) {
  $register.params.avatar = file
}

function Reset() {
  if (!cropper) return
  cropper.reset()
}
</script>
