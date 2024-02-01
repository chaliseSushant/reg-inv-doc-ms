import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const revisionApi = createApi({
  reducerPath: "revisionApi",
  baseQuery: fetchBaseQuery({
    baseUrl,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem("token");
      if (token) {
        headers.set("authorization", `Bearer ${token}`);
      }
      return headers;
    },
  }),
  tagTypes: ["Revisions", "Revision"],
  endpoints: (builder) => ({
    getRevisions: builder.query({
      query: (file_id) => `/revisions/${file_id}`,
      providesTags: (result, error, arg) =>
        result
          ? [...result.map(({ id }) => ({ type: "Revision", id })), "Revision"]
          : ["Revision"],
    }),
  }),
});

export const { useGetRevisionsQuery } = revisionApi;
