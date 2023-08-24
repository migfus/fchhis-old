<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Report Form
            </div>
            <div class="card-body">
                <div>
                    <table>
                        <tr>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Country</th>
                        </tr>
                        <tr>
                            <td>Alfreds Futterkiste</td>
                            <td>Maria Anders</td>
                            <td>Germany</td>
                        </tr>
                        <tr>
                            <td>Centro comercial Moctezuma</td>
                            <td>Francisco Chang</td>
                            <td>Mexico</td>
                        </tr>
                    </table>
                </div>

                <button @click="Export" class="btn btn-info">Export</button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { read, utils, writeFile } from 'xlsx';
import axios from 'axios'

async function Export() {
    let data = await axios.get('"https://sheetjs.com/pres.numbers')
    console.log('Export', utils.sheet_to_json(read(data)))

    // const table = ref()
    // const excel = utils.table_to_book(table)
    // writeFile(excel, 'Export.xlsx')


}
</script>
