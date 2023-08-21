<template>
  <div class="row">
    <div class="col-12 col-md-4">
      <NewUsersCard />
    </div>

    <div class="col-12 col-md-4">
      <SemiAnnual />
    </div>

    <div class="col-12 col-md-4">
      <AnnualCard />
    </div>

    <div class="col-12 col-md-4">
      <TopAgentCard />
    </div>

    <div class="col-12 col-md-4 p-0">
      <IncomeCard />
    </div>

    <div class="col-12 col-md-4 p-0">
      <UsersCard />
    </div>

    <div class="col-12">
      <UserList />
    </div>

    <div class="col-12">
      <PlanRanking />
    </div>


  </div>
</template>

<script setup>
import UserList from './UserList.vue';

import NewUsersCard from './NewUsersCard.vue';
import SemiAnnual from './SemiAnnual.vue';
import AnnualCard from './AnnualCard.vue'

import IncomeCard from './IncomeCard.vue'
import UsersCard from './UsersCard.vue'
import TopAgentCard from './TopAgentCard.vue'

import PlanRanking from './PlanRanking.vue'
</script>
