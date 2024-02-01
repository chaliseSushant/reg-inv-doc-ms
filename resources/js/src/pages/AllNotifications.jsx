import { PageHeader, Space, Row, Col, List, Skeleton } from "antd";
import React, { useState } from "react";
import { useNavigate } from "react-router";
import {
  useGetAllNotificationsQuery,
  useSetNotificationAsReadMutation,
} from "../services/notificationApi";

const AllNotifications = () => {
  const [page, setPage] = useState(1);

  const formData = new FormData();
  const navigate = useNavigate();
  const {
    data: allNotifications,
    isSuccess,
    isFetching,
    isLoading,
  } = useGetAllNotificationsQuery(page);
  const [setNotificationAsRead, { isSuccess: markAsReadSuccess }] =
    useSetNotificationAsReadMutation();
  const handleChange = async (id, registration_id) => {
    formData.append("notification_id", id);
    await setNotificationAsRead(formData);
    navigate(`/registration_details/${registration_id}`);
  };

  const handlePageChange = (pagination, filters, options) => {
    setPage(pagination);
  };

  //   const [loading, setLoading] = useState(false);
  //   const [list, setList] = useState([]);

  if (isLoading) return <Skeleton active />;
  return (
    <Space direction="vertical" style={{ display: "flex" }} size="middle">
      <PageHeader title="All Notifications" />
      <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
        <Col span={24}>
          <List
            header={<div>Header</div>}
            dataSource={allNotifications.data}
            size="medium"
            pagination={{
              pageSize: 10,
              total: allNotifications.meta.total,
              onChange: handlePageChange,
              current: allNotifications.meta.current_page,
            }}
            renderItem={(item) => (
                <a
                className="notification-list-item"
                onClick={() => handleChange(item.id, item.data.registration_id)}
              >
                <List.Item key={item.id}>
                  <List.Item.Meta
                    title={item.data.subject}
                    description={item.data.assign_remarks}
                  />
                  {console.log(item.created_at)}
                  <div style={{ marginRight: "10px" }}>{item.created_at}</div>
                </List.Item>
              </a>
            )}
          />
        </Col>
      </Row>
    </Space>
  );
};

export default AllNotifications;
