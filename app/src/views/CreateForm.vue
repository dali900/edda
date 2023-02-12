<template>
    <div class="create-form flex justify-content-center align-items-start mt-2">
        <Card class="create-form-card">
            <template #title> 
                Create new form
            </template>
            <template #content>
                <div class="new-form">
                    <div class="system-field mb-3">
                        <label for="form-name" :class="{'p-error': errorFields.name}">Name</label>
                        <InputText id="form-name" v-model="formData.name" :class="{'p-invalid': errorFields.name}"></InputText>
                        <small class="p-error">{{errorFields.name}}</small>
                    </div>
                    <div class="fields grid" >
                        <div class="field col-12 md:col-6 lg:col-6" v-for="(field, key) in formData.fields">
                            <div class="field-wrapper p-3">
                                <div class="system-field">
                                    <label for="field-title" :class="{'p-error': errorFields.fields[key].title}">Title</label>
                                    <InputText id="field-title" v-model="field.title" :class="{'p-invalid': errorFields.fields[key].title}"></InputText>
                                    <small class="p-error">{{errorFields.fields[key].title}}</small>
                                </div>
                                <div class="system-field">
                                    <label for="field-type" :class="{'p-error': errorFields.fields[key].type}">Type</label>
                                    <Dropdown id="field-type" v-model="field.type" :options="types" optionLabel="name" optionValue="code" :class="{'p-invalid': errorFields.fields[key].type}"></Dropdown>
                                    <small class="p-error">{{errorFields.fields[key].type}}</small>
                                </div>
                            </div>
                        </div>
                        <Divider />
                    </div>
                    <div class="flex justify-content-between">                       
                        <Button icon="pi pi-plus-circle" iconPos="left" label="Add field" @click="addField" class="p-button-secondary"></Button>                       
                        <Button icon="pi pi-save" iconPos="left" label="Save" @click="save" :disable="disabledSaveBtn"></Button>                       
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watchEffect, onMounted, onBeforeMount } from 'vue'
import { storeToRefs } from 'pinia'
import { useFormStore } from '@/stores/form'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import flatpickr from "flatpickr";
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Divider from 'primevue/divider';

const route = useRoute();
const router = useRouter();
const toast = useToast();
const confirm = useConfirm();
const formStore = useFormStore();
const { form } = storeToRefs(formStore);
const disabledSaveBtn = ref(false)

const types = ref([
    {name: "Text", code: "text"},
    {name: "Amount", code: "amount"},
    {name: "Date", code: "date"},
])
const formData = reactive({
    name: "",
    fields: [{
        title: "",
        type: "text"
    }]
})

onBeforeMount(() => {
    if (route.params.formId) {
        formStore.getForm(route.params.formId);
    }
});

const addField = () => {
    formData.fields.push({
        title: "",
        type: "text"
    });
    errorFields.fields.push({
        title: "",
        type: ""
    });
}

const errorFields = reactive({
    name: "",
    fields: [{
        title: "",
        type: ""
    }]
});

const resetErrorFields = () => {
    errorFields.name = "";
    errorFields.fields.map(field => {
        field.title = "";
        field.type = "";
    })
}

const save = () => {
    disabledSaveBtn.value = true;
    resetErrorFields();
    formStore.create(formData, errorFields)
        .then(()=>{
            toast.add({severity:'success', summary: 'New form created!', detail: formData.name, life: 3000});
            router.push({name: 'forms'});
        })
        .catch((er) => {
            console.log(er);
            disabledSaveBtn.value = false;
            toast.add({severity:'error', summary: 'Oops, something went wrong.', detail: 'Please check you inputs.', life: 3000});
        })
}

const confirmDeleteResource = (id) => {
    confirm.require({
        message: 'Are you sure?',
        header: 'Delete',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
            deleteResource(id);
        },
    });
};

const deleteResource = (id) => {
    formStore.delete(id)
        .then(() => {
            toast.add({severity:'success', summary: 'Form deleted.', life: 3000});
        })
        .catch(() => {
            toast.add({severity:'error', summary: 'Oops, something went wrong.', life: 3000});
        })
}

</script>

<style scoped>
.create-form {
    height: 100%;
}
.create-form-card {
    width: 800px;
}
.system-field input {
    width: 100%;
}
.p-dropdown {
    width: 100%;
}
.field {
    box-sizing: border-box;
}
.field-wrapper {
    background-color: #ececec
}
.p-error {
    min-height: 10px;
}
</style>

