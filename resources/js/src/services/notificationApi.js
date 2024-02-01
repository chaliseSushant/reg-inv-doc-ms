import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const baseUrl = process.env.MIX_REACT_APP_BASE_URL;

export const notificationApi = createApi({
    reducerPath: 'notificationApi',
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
    tagTypes:['UnreadNotifications','AllNotifications'],
    endpoints:(builder)=> ({
        getUnreadNotifications:builder.query({
            query:()=>'/notification/unread',
            providesTags:['UnreadNotifications']
        }),
        setNotificationAsRead:builder.mutation({
            query:(formData)=>({
                url:`/notification/mark`,
                method:'POST',
                body:formData
            }),
            invalidatesTags:['UnreadNotifications']
        }),
        getAllNotifications:builder.query({
            query:(page = 1)=> `/notification/get-all?page=${page}`,
            providesTags:['AllNotifications']
        }),
        setMarkAllAsRead:builder.query({
            query:()=> '/notification/mark-all',
            providesTags:['AllNotifications']
        })

    })

});

export const {useGetUnreadNotificationsQuery,useSetNotificationAsReadMutation,useGetAllNotificationsQuery,useSetMarkAllAsReadMutation} = notificationApi;