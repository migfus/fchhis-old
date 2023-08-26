<template>
    <div class="card">
        <div class="card-header">
            <h5>Shortcuts</h5>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-12 col-md-4">
                    <RouterLink :to="{ name: 'users-clients' }">
                        <div class="info-box mb-3 bg-info">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Clients List</span>
                            </div>
                        </div>
                    </RouterLink>
                </div>

                <div class="col-12 col-md-4">
                    <RouterLink :to="{ name: 'users-clients', query: { form: 'add' } }">
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-user-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Add Client</span>
                            </div>
                        </div>
                    </RouterLink>
                </div>

                <div class="col-12 col-md-4">
                    <RouterLink :to="{ name: 'users-clients', query: { form: 'or' } }">
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Add OR</span>
                            </div>
                        </div>
                    </RouterLink>
                </div>

                <div class="col-12 col-md-6">
                    <RouterLink :to="{ name: 'transactions-all', }">
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Transactions List</span>
                            </div>
                        </div>
                    </RouterLink>
                </div>

                <div class="col-12 col-md-6">
                    <RouterLink :to="{ name: 'transactions-all', query: { form: 'add' } }">
                        <div class="info-box mb-3 bg-secondary">
                            <span class="info-box-icon"><i class="fas fa-file-medical"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Add Transactions</span>
                            </div>
                        </div>
                    </RouterLink>
                </div>

            </div>


        </div>

    </div>
</template>

<script setup lang="ts">

</script>
