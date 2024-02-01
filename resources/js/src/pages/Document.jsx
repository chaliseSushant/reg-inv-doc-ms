import { PlusCircleOutlined, SendOutlined } from "@ant-design/icons";
import { Button, Col, PageHeader, Row, Skeleton, Space, Table } from "antd";
import React, { useState } from "react";
import { useNavigate, useParams } from "react-router";
import { useGetDocumentQuery } from "../services/documentApi";
import { useGetDocumentFilesQuery } from "../services/fileApi";

import AddFile from "./drawers/AddFile";
import NewInvoice from "./drawers/NewInvoice";

const Document = () => {
  const [isVisibleAddFile, setIsVisibleAddFile] = useState(false);
  const [isVisible, setIsVisible] = useState(false);

  const navigate = useNavigate();
  const columns = [
    {
      title: "FIle Name",
      dataIndex: "name",
      width: "50%",
    },
    {
      title: "Actions",
      dataIndex: "",
      key: "x",
      render: (file) => (
        <Space>
          <Button
            size="small"
            type="primary"
            onClick={() => navigate(`/document/file/${file.id}`)}
          >
            View File
          </Button>
        </Space>
      ),
    },
  ];

  const { document_id } = useParams();
  const { data, isSuccess, isLoading } = useGetDocumentQuery(document_id);
  const { data: filesData, isLoading: filesLoading } =
    useGetDocumentFilesQuery(document_id);

  const showDrawer = () => {
    setIsVisible(true);
  };
  const showDrawerAddFile = () => {
    setIsVisibleAddFile(true);
  };

  const handleClick = () => {
    setIsVisible(!isVisible);
  };
  const handleClickAddFile = () => {
    setIsVisibleAddFile(!isVisibleAddFile);
  };

  if (isLoading) return <Skeleton active />;
  return (
    <>
      <Space direction="vertical" size="middle" style={{ display: "flex" }}>
        <PageHeader
          title={data.title}
          onBack={() => window.history.back()}
          extra={[
            <Button
              type="primary"
              onClick={handleClickAddFile}
              icon={<PlusCircleOutlined />}
            >
              Add File
            </Button>,
            <Button
              type="primary"
              onClick={handleClick}
              icon={<SendOutlined />}
            >
              Send Invoice
            </Button>,
          ]}
        />
        <Row>
          <Col span={24}>
            {!isLoading && <Table columns={columns} dataSource={filesData} />}
          </Col>
        </Row>
      </Space>
      <AddFile
        showDrawer={isVisibleAddFile}
        handleClick={handleClickAddFile}
        document_id={document_id}
      />
      <NewInvoice
        document_id={document_id}
        showDrawer={isVisible}
        handleClick={handleClick}
      />
    </>
  );
};

export default Document;
