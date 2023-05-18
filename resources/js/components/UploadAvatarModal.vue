<template>
  <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">Change Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-lg-6">
              <VuePictureCropper :boxStyle="config.cropperBoxStyle" :img="$props.modelValue"
                :options="config.cropperOption" class="mb-2" />
            </div> <!-- SECTION COL-->
            <div class="col-12 col-lg-6">
              <div class="form-group">
                <label for="formFile" class="form-label mt-2">Upload Image</label>
                <div class="custom-file">
                  <input ref="uploadInput" type="file" class="custom-file-input" id="customFile"
                    accept="image/jpg, image/jpeg, image/png, image/gif" @change="SelectFile">
                  <label class="custom-file-label" for="customFile">Click To Upload</label>
                </div>
              </div>

              <button data-dismiss="modal" class="btn btn-danger float-right">
                <i class="fas fa-times mr-2"></i>Cancel
              </button>
              <button @click="Reset()" class="btn btn-warning mr-1 float-right">
                <i class="fas fa-redo mr-2"></i>Reset
              </button>
              <button @click="GetResult()" data-dismiss="modal" class="btn btn-info mr-1 float-right">
                <i class="fas fa-upload mr-2"></i>Save
              </button>
            </div> <!-- SECTION COL-->

          </div> <!-- SECTION ROW-->
        </div>
      </div>
    </div>
  </div> <!-- SECTION MODAL-->
</template>

<script setup>
import VuePictureCropper, { cropper } from 'vue-picture-cropper'
import { ref } from 'vue';
import { $DebugInfo } from '@/helpers/debug';

$DebugInfo("Avatar Modal")

const $props = defineProps({
  modelValue: String
})
const emit = defineEmits(['update:modelValue', 'update'])
const uploadInput = ref(null);
const defaultImage = $props.modelValue;
const config = {
  cropperOption: {
    viewMode: 2,
    dragMode: 'crop',
    aspectRatio: 1,
  },
  cropperBoxStyle: {
    width: '100%',
    height: '100%',
    backgroundColor: '#f8f8f8',
    margin: 'auto',
  }
}

function updateValue(val) {
  emit('update:modelValue', val)
}

function SelectFile(event) {
  const { files } = event.target
  if (!files || !files.length) return

  const file = files[0]
  const reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onload = () => {
    updateValue(String(reader.result))
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
  updateValue(base64)
  emit('update')
}

function Reset() {
  if (!cropper) return
  cropper.reset()
  updateValue(defaultImage)
}
</script>
