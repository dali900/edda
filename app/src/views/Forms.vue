<template>
    <div class="forms flex justify-content-center align-items-start mt-2">
        <Card class="forms-card">
            <template #title>
                <div class="flex justify-content-between">
                    <div class="title">Form control center</div>
                    <div>
                        <router-link :to="{ name: 'create-form' }">
                            <Button
                                icon="pi pi-plus-circle"
                                label="Create new form"
                            ></Button>
                        </router-link>
                    </div>
                </div>
            </template>
            <template #content>
                <div class="form-list" v-if="forms.length">
                    <router-link
                        :to="{ name: 'form', params: { formId: form.id } }"
                        v-for="form in forms"
                    >
                        <div
                            class="form flex justify-content-between align-items-center p-2 mb-3"
                        >
                            <div>{{ form.name }}</div>
                            <Button
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-outlined p-button-sm p-button-warning delete-btn"
                                @click.prevent="confirmDeleteResource(form.id)"
                            />
                        </div>
                    </router-link>
                </div>
                <div v-else>
                    No forms.
                    <router-link :to="{ name: 'create-form' }"
                        >Create</router-link
                    >
                    you first form.
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onUnmounted } from "vue";
import { storeToRefs } from "pinia";
import { useFormStore } from "@/stores/form";
import { useRoute } from "vue-router";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

const route = useRoute();
const toast = useToast();
const confirm = useConfirm();
const formStore = useFormStore();
const { forms } = storeToRefs(formStore);
formStore.getForms();

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
.forms {
    height: 100%;
}
.forms-card {
    width: 800px;
}
.form {
    border: 1px solid lightgray;
    height: 50px;
}
.form:hover {
    background-color: #17403e;
    color: white;
    border-color: #17403e;
    cursor: pointer;
}
.form .delete-btn {
    visibility: hidden;
}
.form:hover .delete-btn {
    visibility: visible;
}
.form .delete-btn:hover {
    color: red !important;
}
a {
    color: inherit;
    text-decoration: inherit;
}
</style>
