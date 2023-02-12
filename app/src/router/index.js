import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Forms from "../views/Forms.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/forms",
      name: "forms",
      component: () => import("../views/Forms.vue"),
    },
    {
      path: "/form/:formId?",
      name: "form",
      component: () => import("../views/Form.vue"),
    },
    {
      path: "/create-form",
      name: "create-form",
      component: () => import("../views/CreateForm.vue"),
    },
  ],
});

export default router;
