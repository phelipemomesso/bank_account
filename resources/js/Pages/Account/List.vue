<template>
  <Head title="My Transactions" />
  <BreezeAuthenticatedLayout>
    
    <template #header>
        <div class="py-6 float-left">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight"> My Transactions</h2>
        </div>
        <div class="py-6 float-right">
          Balance: US$ {{ $page.props.account.balance }}
        </div>
        <p class="clear-both"></p>         
    </template>
    
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
          
          <table class="table-fixed w-full">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2">Date/Hour</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Value</th>
                <th class="px-4 py-2">Type</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in data">
                <td class="border px-4 py-2">{{ formatDate(row.created_at) }}</td>
                <td class="border px-4 py-2">{{ row.description }}</td>
                <td class="border px-4 py-2">US$ {{ row.amount }}</td>
                <td class="border px-4 py-2">{{ row.type == 'D'? 'Debit' : 'Credit' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        </div>  
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import dayjs from 'dayjs';
  import {
    Head,
    Link
  } from "@inertiajs/inertia-vue3";

  export default {
    components: {
      BreezeAuthenticatedLayout,
        dayjs,
        Head,
        Link,
    },
    props: ['data', 'account', 'errors'],
    data() {
      return {
      }
    },
    methods: {
      formatDate(dateString) {
        const date = dayjs(dateString);
        return date.format('D/M/YYYY H:mm');
      },
    }
  }
</script>