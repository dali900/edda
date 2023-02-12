<template>
    <div class="form flex justify-content-center align-items-start mt-2">
        <Card class="form-card">
            <template #title>
                <div class="flex justify-content-between" v-if="form">
                    <div class="title">{{ form.name }}</div>
                    <div class="flex">
                        <Button
                            icon="pi pi-refresh"
                            iconPos="left" 
                            class="p-button-rounded p-button-outlined p-button-sm mr-1"
                            label="Reset fields"
                            @click="confirmResetFields"
                        />
                        <div class="delte-btn">
                            <Button
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-outlined p-button-sm p-button-warning delete-btn"
                                @click.prevent="confirmDeleteResource(form.id)"
                            />
                        </div>
                    </div>
                </div>
                <div v-else>Can't find form.</div>
            </template>
            <template #content>
                <div class="form" v-if="formFieldsData.length > 0">
                    <div class="form-fields">
                        <div class="field" v-for="(field, key) in formFieldsData">
                            <div class="text-field" v-if="field.type == 'text'">
                                <label :for="'text-'+key">{{field.title}}</label>
                                <InputText :id="'text-'+key" v-model="field.value"></InputText>
                            </div>
                            <div class="date-field" v-else-if="field.type == 'date'">
                                <label :for="'date-'+key">{{field.title}}</label>
                                <flat-pickr :id="'date-'+key" v-model="field.value" :config="dateConfig" class="p-inputtext p-component"/>
                            </div>
                            <div class="amount-field" v-else-if="field.type == 'amount'">
                                <label :for="'amount-'+key">{{field.title}}</label>
                                <InputText :id="'amount-'+key" v-model="field.value"></InputText>
                            </div>
                        </div>
                    </div>
                    <div class="options flex justify-content-between">
                        <Button icon="pi pi-save" iconPos="left" label="Save" @click="save" :disable="disabledSaveBtn"></Button>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import {
    ref,
    reactive,
    watch,
    onBeforeMount,
} from "vue";
import { storeToRefs } from "pinia";
import { useFormStore } from "@/stores/form";
import { useRoute } from "vue-router";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Dropdown from "primevue/dropdown";
import Divider from "primevue/divider";

const route = useRoute();
const toast = useToast();
const confirm = useConfirm();
const formStore = useFormStore();
const { form } = storeToRefs(formStore);
const dateField = ref(null);
const disabledSaveBtn = ref(false);
const formFieldsData = ref([]);
const dateConfig = reactive({
    mode: 'multiple',
    dateFormat: "Y-m-d",
    defaultDate: [],
})

onBeforeMount(() => {
    if (route.params.formId) {
        formStore.getForm(route.params.formId);
    }
});

watch(form, (newValue, oldValue) => {
    if(form.value){
        setFormData();
    }
})

const setFormData = () => {
    formFieldsData.value = [];
    for (const key in form.value.fields) {
        const field = form.value.fields[key];
        formFieldsData.value.push({
            id: field.id,
            form_id: field.form_id,
            title: field.title,
            type: field.type,
            value: field.value
        })
    }
}

const save = () => {
    if(form.value){
        disabledSaveBtn.value = true;
        formStore.updateFields(form.value.id, {fields: formFieldsData.value})
            .then(()=>{
                toast.add({severity:'success', summary: 'Form fields updated!', detail: form.value.name, life: 3000});
            })
            .catch((er) => {
                disabledSaveBtn.value = false;
                toast.add({severity:'error', summary: 'Oops, something went wrong.', detail: 'Please check you inputs.', life: 3000});
            })
    }
}

const confirmResetFields = (id) => {
    confirm.require({
        message: "Are you sure?",
        header: "Reset fields",
        icon: "pi pi-exclamation-triangle",
        accept: () => {
            resetFields(id);
        },
    });
};

const resetFields = () => {
    if(form.value){
        disabledSaveBtn.value = true;
        formStore.resetFields(form.value.id)
            .then(()=>{
                toast.add({severity:'success', summary: 'Form fields reseted!', detail: form.value.name, life: 3000});
            })
            .catch((er) => {
                disabledSaveBtn.value = false;
                toast.add({severity:'error', summary: 'Oops, something went wrong.', detail: 'Please check you inputs.', life: 3000});
            })
    }
}

const confirmDeleteResource = (id) => {
    confirm.require({
        message: "Are you sure?",
        header: "Delete",
        icon: "pi pi-exclamation-triangle",
        accept: () => {
            deleteResource(id);
        },
    });
};

const deleteResource = (id) => {
    formStore
        .delete(id)
        .then(() => {
            toast.add({
                severity: "success",
                summary: "Form deleted.",
                life: 3000,
            });
        })
        .catch(() => {
            toast.add({
                severity: "error",
                summary: "Oops, something went wrong.",
                life: 3000,
            });
        });
};
</script>

<style scoped>
.form {
    height: 100%;
}
.form-card {
    width: 800px;
}
.form .delete-btn:hover {
    color: red !important;
}
.field input {
    width: 100%;
}

</style>
