import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers} from '@vueuse/core'

type IContent = Array<{
    id: number
    name: string
    cities: Array<{
        id: number
        name: string
        zipcode: number
    }>
}>

const title = 'public/AddressStore'

export const useAddressStore = defineStore(title, () => {
    const content = useStorage<IContent>(`${title}/content`, [], localStorage, { serializer: StorageSerializers.object })

    async function GetAPI() {
        try {
            let { data } = await axios.get('/api/public/address')
            content.value = data
        }
        catch(e) {
            console.log("Get API Error", {e})
        }
    }

    // SECTION ADDRESS
    function CityIDToDesc(id: Number) {
        if(id) {
            for (let i = 0; content.value.length > i; i++) {
                const { cities } = content.value[i];
                for (let f = 0; cities.length > f; f++) {
                    if (cities[f].id == id) {
                        return cities[f].name;
                    }
                }
            }
        }
        return null;
    };

    function ProvinceIDToDesc(id: Number) {
        if(id) {
            for (let i = 0; content.value.length > i; i++) {
                const province = content.value[i];
                for (let f = 0; province.cities.length > f; f++) {
                    if (province.cities[f].id == id) {
                        return province.name;
                    }
                }
            }
        }
        return null;
    };

    function CityIDToFullAddress(id: number | bigint) {
        if(id) {
            for (let i = 0; content.value.length > i; i++) {
                const province = content.value[i];
                for (let f = 0; province.cities.length > f; f++) {
                    if (province.cities[f].id == id) {
                        return `${province.cities[f].name}, ${province.name}`;
                    }
                }
            }
        }
        return null;
    };

    function CityIDToProvinceID(id: Number) {
        if(id) {
            for (let i = 0; content.value.length > i; i++) {
                const province = content.value[i];
                for (let f = 0; province.cities.length > f; f++) {
                    if (province.cities[f].id == id) {
                        return province.id;
                    }
                }
            }
        }
        return null
    };

    return {
        content,

        CityIDToDesc,
        ProvinceIDToDesc,
        CityIDToFullAddress,
        CityIDToProvinceID,

        GetAPI
    }
});
