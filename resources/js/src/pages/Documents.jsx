import React from "react";
import {
  Space,
  PageHeader,
  Row,
  Col,
  Skeleton,
  Button,
  Typography,
  Tag,
  Table,
  Pagination,
} from "antd";
import { EyeFilled, FolderFilled, PlusCircleOutlined } from "@ant-design/icons";
import { useGetDocumentsQuery } from "../services/documentApi";
import AddDocument from "./drawers/AddDocument";
import { useState } from "react";
import { useNavigate } from "react-router";
import ViewRegistrationInvoice from "./drawers/ViewRegistrationInvoice";

const Documents = () => {
  const { Text } = Typography;
  const [page,setPage] = useState(1);
  
  const { data: documents, isSuccess, isLoading } = useGetDocumentsQuery(page);
  const [documentId, setDocumentId] = useState(0);
  const [isVisible, setIsVisible] = useState(false);
  const [isVisibleRegistrationInvoice, setIsVisibleRegistrationInvoice] =
    useState(false);
  const handleClick = () => {
    setIsVisible(!isVisible);
  };
  const showDrawer = () => {
    setIsVisible(true);
  };

  const handleDocument = (id) => {
    setDocumentId(id);
    showDrawerRegistrationInvoice();
  };

  const handleClickRegistrationInvoice = () => {
    setIsVisibleRegistrationInvoice(!isVisibleRegistrationInvoice);
  };
  const showDrawerRegistrationInvoice = () => {
    setIsVisibleRegistrationInvoice(true);
  };

  const columns = [
    {
      title: "Document Number",
      dataIndex: "document_number",
      key: "document_number",
      width: "20%",
    },
    {
      key: "title",
      title: "Title",
      dataIndex: "title",
    },
    {
      key: "id",
      title: "Secrecy / Urgency",
      width: "20%",
      render: (_,{ secrecy, urgency }) => 
         (
          <>
            <Tag color="blue" key={1}>
              {secrecy}
            </Tag>
            <Tag color="red" key={2}>
              {urgency}
            </Tag>
          </>
        )
    },
    {
      key: "x",
      title: "Action",
      dataIndex: "",
      render: (_,document) => (
        <Space>
          <Button type="primary" onClick={() => handleDocument(document.id)}>
            Registration / Invoice
          </Button>
          <Button
            type="primary"
            onClick={() => navigate(`/document/${document.id}`)}
            icon={<EyeFilled />}
          >
            View Files
          </Button>
        </Space>
      ),
    },
  ];
  const navigate = useNavigate();
  const handleChange = (pagination,filters,sorter)=>
  {
      setPage(pagination);
  }
  if (!isSuccess) return <Skeleton active />;
  return (
    <>
      <Space direction="vertical" size="middle" style={{ display: "flex" }}>
        <PageHeader
          title="All Documents"
          extra=
          {
            <Button
              onClick={handleClick}
              type="primary"
              icon={<PlusCircleOutlined />}
            >
              Add Document
            </Button>
          }
        />
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24} className="gutter-row">
            <Table
              columns={columns}
              dataSource={documents.data}
              pagination={{
                pageSize: 10,
                total: documents.meta.total,
                onChange: handleChange,
                current:documents.meta.current_page
              }}
            />
          </Col>
        </Row>
      </Space>
      <AddDocument showDrawer={isVisible} handleClick={handleClick} />
      <ViewRegistrationInvoice
        showDrawer={isVisibleRegistrationInvoice}
        handleClick={handleClickRegistrationInvoice}
        document_id={documentId}
      />
    </>
  );
};

export default Documents;