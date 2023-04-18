import { ref } from "vue";
import { defineStore } from "pinia";
import axios from "axios";

export const useDashboardStore = defineStore("dashboard", () => {
  const content = ref({ usersCount: false, transactionCount: false });

  async function GetAPI() {
    try {
      let { data : {data}}  = await axios.get("/api/dashboard");
      console.log(data)
      content.value = data;
    }
    catch (e) {
      console.log({ e });
    }
  }

  return { content, GetAPI };
});
