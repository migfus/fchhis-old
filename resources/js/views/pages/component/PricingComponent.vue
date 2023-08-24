<template>
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <figure class="note note-success p-4">
            <blockquote class="blockquote">
                <p class="pb-2">
                    <i class="fas fa-quote-left fa-xs text-info"></i>
                    A family and individual protection care it is designed to help and give
                    protection to all families that offers low
                    rates in a form of savings in ease the burdern of life uncertainties.
                    <i class="fas fa-quote-right fa-xs text-info"></i>
                </p>
            </blockquote>
        </figure>


        <h1 class="display-4 fw-normal mb-4">Pricing</h1>



        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div v-for="row in plan" :key="row.name" class="col">
                <div :class="`card mb-4 rounded-3 shadow-sm card-${row.color}`">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">{{ row.name }}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="">{{ row.month }}<small class="text-muted fw-light">/mo</small></h1>
                        <div>{{ row.desc }}</div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr v-for="row2 in row.benefits">
                                        <td>{{ row2.desc }}</td>
                                        <td v-if="row2.price">
                                            <strong v-if="row2.bold" v-html="row2.price"></strong>
                                            <div v-else v-html="row2.price"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-success">
                                <tbody>
                                    <tr v-for="row2 in row.fees">
                                        <td class="table-success">{{ row2.desc }}</td>
                                        <td class="table-success" v-if="row2.price">
                                            <strong v-if="row2.bold" v-html="row2.price"></strong>
                                            <div v-else v-html="row2.price"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="display-6 text-center mb-4">Compare plans</h2>

    <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                    <th style="width: 40%;"></th>
                    <th style="width: 15%;" class="text-info">Jasper</th>
                    <th style="width: 15%;" class="text-success">Jade</th>
                    <th style="width: 15%;" class="text-warning">Beryl</th>
                    <th style="width: 15%;" class="text-purple">Onyx</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" class="text-start">Burial Package Services</th>
                    <td>25,000</td>
                    <td>25,000</td>
                    <td><strong>30,000</strong></td>
                    <td><strong>30,000</strong></td>
                </tr>

                <tr>
                    <th scope="row" class="text-start">Natural Death</th>
                    <td>-</td>
                    <td>12,500</td>
                    <td><strong>17,000</strong></td>
                    <td><strong>30,000</strong></td>

                </tr>

                <tr>
                    <th scope="row" class="text-start">Accidental Death</th>
                    <td>-</td>
                    <td>30,000</td>
                    <td><strong>17,000</strong></td>
                    <td><strong>30,000</strong></td>
                </tr>

                <tr>
                    <th scope="row" colspan="5" class="text-start">Plus Benefits for Dependents (Only Natural Death)</th>
                </tr>

                <tr>
                    <th scope="row" class="text-start">Family Cash Assistance</th>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td><strong>6,000</strong></td>
                </tr>

                <tr>
                    <th scope="row" class="text-start">Burial Package Service</th>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td><strong>30,000</strong></td>
                </tr>

            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const plan = ref([
    {
        name: 'Jasper',
        desc: '18-70 Years Old',
        benefits: [
            {
                desc: 'Burial Package',
                price: '25,000',
            },
            {
                desc: 'Natural Death',
                price: '<i class="fas fa-times"></i>',
            },
            {
                desc: 'Accidental Death',
                price: '<i class="fas fa-times"></i>',
            }
        ],
        fees: [
            {
                desc: 'Contract Price',
                price: '27,000',
            },
            {
                desc: 'Spot Payment',
                price: '26,000',
            },
            {
                desc: 'Spot Service',
                price: '28,000'
            },
            {
                desc: 'Annual',
                price: '5,064'
            },
            {
                desc: 'Semi-Annual',
                price: '2,532'
            },
            {
                desc: 'Quarterly',
                price: '1,266',
            },
            {
                desc: 'Monthly',
                price: '450'
            }
        ],
        month: '450',
        color: 'info',
    },
    {
        name: 'Jade',
        desc: '18-70 Years Old',
        benefits: [
            {
                desc: 'Burial Package',
                price: '25,000',
            },
            {
                desc: 'Natural Death',
                price: '12,500',
            },
            {
                desc: 'Accidental Death',
                price: '30,000',
                bold: true,
            }
        ],
        fees: [
            {
                desc: 'Contract Price',
                price: '29,700',
            },
            {
                desc: 'Spot Payment',
                price: '27,000',
            },
            {
                desc: 'Spot Service',
                price: '29,000'
            },
            {
                desc: 'Annual',
                price: '5,556'
            },
            {
                desc: 'Semi-Annual',
                price: '2,778'
            },
            {
                desc: 'Quarterly',
                price: '1,389',
            },
            {
                desc: 'Monthly',
                price: '495'
            }
        ],
        month: '495',
        color: 'success',
    },
    {
        name: 'Beryl',
        desc: '18-70 Years Old',
        benefits: [
            {
                desc: 'Burial Package',
                price: '30,000',
                bold: true,
            },
            {
                desc: 'Natural Death',
                price: '17,000',
                bold: true,
            },
            {
                desc: 'Accidental Death',
                price: '30,000',
                bold: true,
            }
        ],
        fees: [
            {
                desc: 'Contract Price',
                price: '39,000',
            },
            {
                desc: 'Spot Payment',
                price: '30,000',
            },
            {
                desc: 'Spot Service',
                price: '33,000',
            },
            {
                desc: 'Annual',
                price: '5,064'
            },
            {
                desc: 'Semi-Annual',
                price: '3,660'
            },
            {
                desc: 'Quarterly',
                price: '1,266',
            },
            {
                desc: 'Monthly',
                price: '450'
            }
        ],
        month: '650',
        color: 'warning',
    },
    {
        name: 'Onyx',
        desc: '18-70 Years Old',
        benefits: [
            {
                desc: 'Burial Package',
                price: '30,000',
                bold: true
            },
            {
                desc: 'Natural Death',
                price: '17,000',
                bold: true,
            },
            {
                desc: 'Accidental Death',
                price: '30,000',
                bold: true,
            },
            {
                desc: 'Plus Benefits for Dependents',
            },
            {
                desc: 'Family Cash Assistance',
                price: '6,000',
                bold: true,
            },
            {
                desc: 'Burial Package',
                price: '30,000',
                bold: true,
            },
        ],
        fees: [
            {
                desc: 'Contract Price',
                price: '78,000',
            },
            {
                desc: 'Spot Payment',
                price: '68,000',
            },
            {
                desc: 'Spot Service',
                price: '73,000',
            },
            {
                desc: 'Annual',
                price: '14,640'
            },
            {
                desc: 'Semi-Annual',
                price: '7,320'
            },
            {
                desc: 'Quarterly',
                price: '3,660',
            },
            {
                desc: 'Monthly',
                price: '1,300'
            }
        ],
        month: '1,300',
        color: 'purple',
    },
]);


</script>

<style scope>
.table-succ {
    background-color: #ffe082;
}
</style>
