<template>
 <Head title="Edit-User" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Respond/Message/{{ Message.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col">
                                <div class="w-full">
                                    <div v-if="$page.props.flash != false">
                                         <div id="alert-border-1" class="flex p-4 mb-4 bg-blue-100 border-t-4 border-blue-500 dark:bg-blue-200" role="alert">                                         
                                            <div class="ml-3 text-sm font-medium text-blue-700">
                                               {{ $page.props.flash }}
                                            </div>
                                        </div>
                                    </div>
                                   <div class="mt-10 sm:mt-0">
                                        <div class="md:grid md:grid-cols-3 md:gap-6">
                                            <div class="md:col-span-1">
                                            <div class="px-4 sm:px-0">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900">Admin</h3>
                                                <p class="mt-1 text-sm text-gray-600">
                                                   Respond to Message
                                                </p>
                                            </div>
                                            </div>
                                            <div class="mt-5 md:mt-0 md:col-span-2">
                                            <form @submit.prevent="update(`${Message.id}`)">
                                                <div class="shadow overflow-hidden sm:rounded-md">
                                                <div class="px-4 py-5 bg-white sm:p-6">
                                                    <div class="grid grid-cols-12 gap-6">
                                                        <div class="col-span-3 sm:col-span-3">
                                                            <label  class="block text-sm font-medium text-blue-600 ">Job Title</label>
                                                            <span class="mt-1 btn-green">{{Message.initiator.name}}</span>                               
                                                        </div>

                                                        <div class="col-span-3 sm:col-span-3">
                                                            <label  class="block text-sm font-medium text-blue-600 ">User Department</label>
                                                            <span class="mt-1 btn-green">{{Message.initiator.dept}}</span>                               
                                                        </div>

                                                        <div class="col-span-3 sm:col-span-3">
                                                            <label  class="block text-sm font-medium text-blue-600 ">User Site</label>
                                                            <span class="mt-1 btn-green">{{Message.initiator.site}}</span>                               
                                                        </div>

                                                        <div class="col-span-3 sm:col-span-3">
                                                            <label  class="block text-sm font-medium text-blue-600 ">Department in Query</label>
                                                            <span class="mt-1 btn-green">{{Message.dept.department}}</span>                               
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <label  class="block text-sm font-medium text-blue-600 ">Query</label>
                                                        <span class="mt-2 btn-green">{{Message.query}}</span>                               
                                                    </div>

                                                    <div class="mt-3">
                                                        <label  class="block text-sm font-medium text-blue-600 ">Add Response</label>
                                                        <textarea v-model="form.response" rows="3" class="mt-3 w-full btn-green" placeholder="Type your response here..."></textarea>
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.response">{{ form.errors.response }}</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="px-4 py-2 text-right sm:px-6">
                                                    <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                        Send
                                                    </Button>
                                                </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

</template>

<script>

import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Button from '@/Components/Button.vue'
import { Head,Link } from '@inertiajs/inertia-vue3';
export default {
   components:{
     BreezeAuthenticatedLayout,
     Head,
     Button,
     Link,
   },
   data() {
    return {
      form: this.$inertia.form({
        response: this.$props.Message.response,
      }),
    }
  },
  methods: {
    update(id) {
        this.form.patch(`/update-message/${id}`)
     }
  },
   props: {
      Message: Object,
    },
}
</script>
