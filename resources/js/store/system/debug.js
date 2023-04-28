import { ref } from "vue";
import { defineStore } from "pinia";

export const useDebugStore = defineStore("debug", () => {
  const enabled = ref(false);

  function Err(message, input) {
    if (enabled.value) return console.log(`%c${message}`, "color: red", input);
  }

  function Log(message, input) {
    if (enabled.value) return console.log(`%c${message}`, "color: cyan", input);
  }

  return { Err, Log };
});
