import { ref } from "vue";
import { defineStore } from "pinia";
import axios from "axios";

export const useDashboard = defineStore("dashbard", () => {
  const content = ref({});

  async function GetAPI() {
    try {
      let { data } = await axios.get("/api/dashboard");
      content.value = data;
    } catch (e) {
      console.log({ e });
    }
  }

  return { content, GetAPI };
});
