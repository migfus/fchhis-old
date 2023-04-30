<template>
  <div class="row">
    <ResponsiveCard />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";

import ResponsiveCard from './contents/ResponsiveCard.vue';

const PDFContent = ref({
  content: [
    'First Paragrahp',
    'Secondar Parharsdf'
  ]
})
pdfMake.vfs = pdfFonts.pdfMake.vfs;


onMounted(() => {
  pdfMake.createPdf(PDFContent.value).open();
});
</script>

