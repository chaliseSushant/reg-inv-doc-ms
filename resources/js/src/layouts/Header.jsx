import React, { useState } from "react";
import {
  BellTwoTone,
  MenuFoldOutlined,
  MenuUnfoldOutlined,
} from "@ant-design/icons";
import { Badge, Dropdown, List } from "antd";
import {
  useGetUnreadNotificationsQuery,
  useSetNotificationAsReadMutation,
} from "../services/notificationApi";
import { useNavigate } from "react-router";

const DashboardHeader = () => {
  const navigate = useNavigate();
  const formData = new FormData();
  const { data: unreadNotifications, isSuccess } =
    useGetUnreadNotificationsQuery(undefined, { pollingInterval: 900000 });
  const [setNotificationAsRead, { isSuccess: markAsReadSuccess }] =
    useSetNotificationAsReadMutation();

  const handleChange = async (id, registration_id) => {
    formData.append("notification_id", id);
    await setNotificationAsRead(formData);
    navigate(`registration_details/${registration_id}`);
  };

  const list = (
    <List
      size="small"
      dataSource={isSuccess && unreadNotifications}
      itemLayout="horizontal"
      bordered
      footer={<a style={{ alignSelf: "center !important" }} onClick={()=>navigate('notifications/all')}>See All Notifications</a>}
      header={<a style={{ textAlign: "center" }}>Mark all as Read</a>}
      renderItem={(item) => (
        <a
          className="notification-list-item"
          onClick={() => handleChange(item.id, item.data.registration_id)}
        >
          <List.Item key={item.key}>
            <List.Item.Meta
              title={item.data.subject}
              description={item.data.assign_remarks}
            />
            <div style={{ marginRight: "10px" }}>{item.created_at}</div>
          </List.Item>
        </a>
      )}
    />
  );

  return (
    <>
      <Dropdown
        trigger={["click"]}
        overlay={list}
        overlayStyle={{ width: "520px" }}
      >
        <a href="#" style={{ float: "right", marginRight: 25 }}>
          <Badge count={isSuccess && unreadNotifications.length}>
            <BellTwoTone style={{ fontSize: 22 }} />
          </Badge>
        </a>
      </Dropdown>
    </>
  );
};

export default DashboardHeader;
