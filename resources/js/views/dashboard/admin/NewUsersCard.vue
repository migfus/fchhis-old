<template>
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title"><strong>New Users</strong></h3>
            <div class="card-tools">
                <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>More</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $stat.content.newUsers" :key="row.username">
                        <td>
                            <img :src="row.avatar || '/images/logo.png'" alt="Product 1"
                                class="img-circle img-size-32 mr-2">
                            {{ row.name }}
                        </td>
                        <td>
                            {{ RoleToDesc(row.user.role) }}
                        </td>
                        <td>
                            {{ moment(row.created_at).format('MMM D, YYYY') }}
                        </td>
                        <td>
                            <RouterLink :to="`/user/${row.id}`" class="text-muted">
                                <i class="fas fa-search"></i>
                            </RouterLink>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useStatisticStore } from '@/store/dashboard/StatisticStore';
import { RoleToDesc } from '@/helpers/converter'
import moment from 'moment'

const $stat = useStatisticStore();
</script>
