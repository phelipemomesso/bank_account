<template>
  <Head title="Deposit" />
  <BreezeAuthenticatedLayout>
    <template #header>
        <div class="py-6 float-left">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Purchase</h2>
        </div>
        <div class="py-6 float-right">
          Balance: US$ {{ $page.props.account.balance }}
        </div>
        <p class="clear-both"></p>         
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

          <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                      </div>
                    </div>

          <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Add Purchase</button>
          
          <table class="table-fixed w-full">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2">Date/Hour</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Value</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in data">
                <td class="border px-4 py-2">{{ formatDate(row.created_at) }}</td>
                <td class="border px-4 py-2">{{ row.description }}</td>
                <td class="border px-4 py-2">US$ {{ row.amount }}</td>
              </tr>
            </tbody>
          </table>

          <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
              <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
              </div>
              <!-- This element is to trick the browser into centering the modal contents. -->
              <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​ <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form>
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                      <BreezeValidationErrors class="mb-4" />
                      <div class="mt-4">
                                <BreezeLabel for="amount" value="Amount" />
                                <CurrencyInput
                                    v-model="form.amount"
                                    :options="{ currency: 'USD' }"
                                    required
                                />
                            </div>
                            <div class="mt-4">
                                <BreezeLabel
                                    for="description"
                                    value="Description"
                                />
                                <BreezeInput
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    required
                                />
                            </div>
                    </div>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                      <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)"> Save </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                      <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"> Cancel </button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
  import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import CurrencyInput from "@/Components/CurrencyInput.vue";
import dayjs from 'dayjs';
  import {
    Head,
    Link
  } from "@inertiajs/inertia-vue3";
import { cloneDeep } from 'lodash';
  export default {
    components: {
      BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        CurrencyInput,
        dayjs,
        Head,
        Link,
    },
    props: ['data', 'account', 'errors'],
    data() {
      return {
        editMode: false,
        isOpen: false,
        form: {
          name: null,
          email: null,
        },
      }
    },
    methods: {
      formatDate(dateString) {
            const date = dayjs(dateString);
            return date.format('D/M/YYYY H:mm');
      },
      openModal: function() {
        this.isOpen = true;
      },
      closeModal: function() {
        this.isOpen = false;
        this.reset();
        this.editMode = false;
      },
      reset: function() {
        this.form = {
          title: null,
          body: null,
        }
      },
      save: function(data) {
        this.$inertia.post('/purchase/store', data, {  
            forceFormData: true,
            onSuccess: () => { 
              this.reset();
              this.closeModal();
            },
        })
        this.editMode = false;
      }
    }
  }
</script>