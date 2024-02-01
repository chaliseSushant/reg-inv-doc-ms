import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const registrationApi = createApi({
  reducerPath: "registrationApi",
  baseQuery: fetchBaseQuery({
    baseUrl,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem("token");
      
      // If we have a token set in state, let's assume that we should be passing it.
      if (token) {
        headers.set("authorization", `Bearer ${token}`);
        headers.set("encType", `multipart/form-data`);
      }
      return headers;
    },
  }),
  tagTypes: [
    "Registrations",
    "Registration",
    "RegistrationDocuments",
    "RegistrationDocument",
  ],
  endpoints: (builder) => ({
    getRegistrations: builder.query({
      query: (page = 1) => `/registrations?page=${page}`,
      providesTags: (result, error, args) =>
        result
          ? [
              ...result.data.map(({ id }) => ({ type: "Registrations", id })),
              { type: "Registrations", id: "PARTIAL-LIST" },
            ]
          : [{ type: "Registrations", id: "PARTIAL-LIST" }],
    }),
    getRegistrationDetails: builder.query({
      query: (registration_id) => `/registration/${registration_id}`,
      providesTags: ["Registration"],
    }),
    addRegistration: builder.mutation({
      query: (registration) => ({
        url: "/registration/save",
        method: "POST",
        body: registration,
      }),
      invalidatesTags: ["Registrations"],
    }),
    assignDocument: builder.mutation({
      query: (data) => ({
        url: "/registration/assign",
        method: "POST",
        body: data,
      }),
      invalidatesTags: ["Registrations"],
    }),
    getAssignees: builder.query({
      query: (document_id) => `registration/assigns/${document_id}`,
      providesTags: ["RegistrationDocuments"],
    }),
    getRegistrationDocument: builder.query({
      query: (registration_id) => `/registration/document/${registration_id}`,
      providesTags: ["RegistrationDocument"],
    }),
  }),
});

export const {
  useGetRegistrationsQuery,
  useGetRegistrationDetailsQuery,
  useGetAssigneesQuery,
  useAddRegistrationMutation,
  useAssignDocumentMutation,
  useGetRegistrationDocumentQuery,
} = registrationApi;
