import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const documentApi = createApi({
  reducerPath: "documentApi",
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
  tagTypes: ["Documents", "Document", "Files"],
  endpoints: (builder) => ({
    getDocuments: builder.query({
      query: (page = 1) => `/documents?page=${page}`,
      providesTags:["Documents"]
      //  (result, error, args) =>
      //   result
      //     ? [
      //         ...result.data.map(({ id }) => ({ type: "Documents", id })),
      //         { type: "Documents", id: "PARTIAL-LIST" },
      //       ]
      //     : [{ type: "Documents", id: "PARTIAL-LIST" }],
    }),
    getDocument: builder.query({
      query: (document_id) => `/document/${document_id}`,
      providesTags: ["Document"],
    }),
    addDocument: builder.mutation({
      query: (document) => ({
        url: "/document/save",
        method: "POST",
        body: document,
      }),
      invalidatesTags: ["Document"],
    }),
    getRegistrationInvoice: builder.query({
      query: (document_id) => `/document/registration-invoice/${document_id}`,
    }),
  }),
});

export const {
  useGetDocumentsQuery,
  useGetDocumentQuery,
  useAddDocumentMutation,
  useGetRegistrationInvoiceQuery,
} = documentApi;
