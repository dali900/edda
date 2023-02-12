import { axios, fillFormErrors } from "@/utils/axios";
import { defineStore } from "pinia";
import { useIndexStore } from "./index";

export const useFormStore = defineStore("form", {
    state: () => ({
        form: null,
        forms: [],
    }),
    getters: {
        loading(state) {
            const indexStore = useIndexStore();
            return indexStore.loading;
        },
    },
    actions: {
        async getForms() {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.get("/forms");
                this.forms = response.data.forms;
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                indexStore.setLoading(false);
                throw error;
            }
        },
        async getForm(id) {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.get("/forms/" + id);
                this.form = response.data.form;
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                indexStore.setLoading(false);
                throw error;
            }
        },
        //create new form
        async create(data, errorFields) {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.post("/forms", data);
                const form = response.data.form;
                //adds the object data to the beginning of the array
                if (this.forms && this.forms.length) {
                    this.forms.unshift(form);
                }
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                fillFormErrors(errorFields, error);
                indexStore.setLoading(false);
                throw error;
            }
        },
        //update form
        async update(id, data, errorFields) {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.put("/forms/" + id, data);
                const form = response.data.form;
                //replace the existing form
                if (this.forms && this.forms.length) {
                    const formIndex = this.forms.findIndex((el) => el.id == id);
                    this.forms[formIndex] = form;
                }
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                fillFormErrors(errorFields, error);
                indexStore.setLoading(false);
                throw error;
            }
        },
        //update form fields
        async updateFields(formId, data) {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.put("/fields/" + formId, data);
                const fields = response.data.fields;
                //replace the existing form fields
                if (this.forms && this.forms.length) {
                    const formIndex = this.forms.findIndex((el) => el.id == formId);
                    this.forms[formIndex].fields = fields;
                }
                if(this.form) {
                    this.form.fields = fields;
                }
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                indexStore.setLoading(false);
                throw error;
            }
        },
        //reset all form fields
        async resetFields(formId) {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.get("/fields/" + formId + "/reset");
                const form = response.data.form;
                //replace the existing form fields
                if (this.forms && this.forms.length) {
                    const formIndex = this.forms.findIndex((el) => el.id == formId);
                    this.forms[formIndex] = form;
                }
                if(this.form) {
                    this.form = form;
                }
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                indexStore.setLoading(false);
                throw error;
            }
        },
        //delete form
        async delete(id) {
            const indexStore = useIndexStore();
            indexStore.setLoading();
            try {
                const response = await axios.delete("/forms/" + id);
                //remove the existing form
                this.forms = this.forms.filter((el) => el.id != id);
                indexStore.setLoading(false);
                return response.data;
            } catch (error) {
                indexStore.setLoading(false);
                throw error;
            }
        },
    },
});
