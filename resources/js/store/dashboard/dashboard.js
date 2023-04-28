import { ref } from "vue";
import { defineStore } from "pinia";
import axios from "axios";
import { $DebugInfo, $Err, $Log } from "@/helpers/debug";

export const useDashboardStore = defineStore("dashboard", () => {
  $DebugInfo('DashboardStore')

  const content = ref(false);

  async function GetAPI(role) {
    try {
      let { data : {data}}  = await axios.get(`/api/dashboard`);
      $Log('GetAPI', data)
      content.value = data;
    }
    catch (e) {
      $Err('GetAPI Err', { e });
    }
  }

  return { content, GetAPI };
});
