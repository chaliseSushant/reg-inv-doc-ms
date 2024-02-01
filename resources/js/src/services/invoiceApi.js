import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const invoiceApi = createApi({
  reducerPath: "invoiceApi",
  baseQuery: fetchBaseQuery({
    baseUrl,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem("token");
      // If we have a token set in state, let's assume that we should be passing it.
      if (token) {
        headers.set("authorization", `Bearer ${token}`);
      }
      return headers;
    },
  }),
  tagTypes: ["Invoices"],
  endpoints: (builder) => ({
    getAllInvoice: builder.query({
      query: (page=1) => `/invoices?page=${page}`,
      providesTags:["Invoices"],
    }),
    getInvoice: builder.query({
      query: (invoice_id) => `/invoice/${invoice_id}`,
      providesTags: ["Invoices"],
    }),
    addInvoice: builder.mutation({
      query: (invoice) => ({
        url: "/invoice/save",
        method: "POST",
        body: invoice,
      }),
    }),
    getInvoiceDocuments: builder.query({
      query: (invoice_id) => `/invoice/${invoice_id}`,
      providesTags: ["Invoices"],
    }),
  }),
});

export const {
  useGetAllInvoiceQuery,
  useAddInvoiceMutation,
  useGetInvoiceQuery,
  useGetInvoiceDocumentsQuery
} = invoiceApi;
