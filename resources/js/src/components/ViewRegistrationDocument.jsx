import { Button, Col, Descriptions, Row, Skeleton, Space, Table } from "antd";
import React from "react";
import { useEffect } from "react";
import { Link } from "react-router-dom";
import { useGetRegistrationDocumentQuery } from "../services/registrationApi";

const ViewRegistrationDocument = ({ registration_id }) => {
  const {
    data: document,
    isLoading,
    isError,
  } = useGetRegistrationDocumentQuery(registration_id);

  if (isLoading) return <Skeleton active />;

  if (isError) return "Not authorized to view document";
  return (
    <Space
      direction="vertical"
      size="middle"
      style={{
        display: "flex",
      }}
    >
      <Descriptions
        title="Documents"
        bordered
        column={{
          xxl: 4,
          xl: 3,
          lg: 3,
          md: 3,
          sm: 2,
          xs: 1,
        }}
      >
        <Descriptions.Item label="Document Number" span={3}>
          {document.document_number}
        </Descriptions.Item>
        <Descriptions.Item label="Urgency" span={2}>
          {document.urgency}
        </Descriptions.Item>
        <Descriptions.Item label="Secrecy">
          {document.secrecy}
        </Descriptions.Item>
        <Descriptions.Item label="Remarks" span={3}>
          {document.remarks}
        </Descriptions.Item>
        <Descriptions.Item label="Files">
          <Space direction="vertical">
            {document.file &&
              document.file.map((item) => {
                return (
                  <Link
                    key={item.id}
                    to={{ pathname: `/document/file/${item.id}` }}
                  >
                    {item.name}
                  </Link>
                );
              })}
          </Space>
        </Descriptions.Item>
      </Descriptions>
    </Space>
  );
};

export default ViewRegistrationDocument;
