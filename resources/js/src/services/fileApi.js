import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const fileApi = createApi({
  reducerPath: "fileApi",
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
  tagTypes: ["File", "Revisions"],
  endpoints: (builder) => ({
    getFile: builder.query({
      query: (file_id) => `/file/${file_id}`,
    }),
    getDocumentFiles: builder.query({
      query: (document_id) => `/document/files/${document_id}`,
      providesTags: (result, error, arg) =>
        result
          ? [...result.map(({ id }) => ({ type: "File", id })), "File"]
          : ["File"],
    }),
    addFile: builder.mutation({
      query: (data) => ({
        url: "/file/add/save",
        method: "POST",
        body: data,
      }),
      invalidatesTags: ["File"],
    }),
    addRevision: builder.mutation({
      query: (data) => ({
        url: "/revision/latest/save",
        method: "POST",
        body: data,
      }),
      invalidatesTags: ["File", "Revisions"],
    }),
    getRevisions: builder.query({
      query: (file_id) => `/revisions/${file_id}`,
      providesTags: (result, error, arg) =>
      result
        ? [...result.map(({ id }) => ({ type: "File", id })), "File"]
        : ["File"],
    }),
  }),
});

export const {
  useGetFileQuery,
  useAddFileMutation,
  useAddRevisionMutation,
  useGetDocumentFilesQuery,
} = fileApi;
