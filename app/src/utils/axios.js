import axios from "axios";

const baseUrl = import.meta.env.VITE_BASE_API_URL;

const http = axios.create({
  withCredentials: true,
  baseURL: baseUrl,
  headers: { "X-Requested-With": "XMLHttpRequest" },
});
export { http as axios };

export const fillFormErrors = (errorFields, error) => {
  const defaultMessage = error.response.data.message;
  const errors = error.response.data.errors;
  console.log(error.response);
  if (error.response.status == 422) {
    for (const key in errorFields) {
      if (errors && errors[key] && errors[key][0] !== "") {
        console.log(errorFields[key]);
        errorFields[key] = errors[key][0];
      }
    }
  }
  if (errorFields.hasOwnProperty("default")) {
    errorFields.default = defaultMessage;
  }
  return errorFields;
};
