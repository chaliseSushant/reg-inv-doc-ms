import { EyeOutlined, FolderFilled } from "@ant-design/icons";
import { Button, Col, PageHeader, Row, Skeleton, Space, Table } from "antd";
import React ,{useState}from "react";
import { useEffect } from "react";
import { render } from "react-dom";
import { useNavigate } from "react-router";
import Dashboard from "../layouts/Dashboard";
import { useGetAllInvoiceQuery } from "../services/invoiceApi";

function Invoices() {
  const [page,setPage] = useState(1); 
  const [invoices,setInvoices] = useState([]);
  let { data: invoiceData, isSuccess,isFetching } = useGetAllInvoiceQuery(page);
  const navigate = useNavigate();
  

  const columns = [
    {
      title: "Invoice Number",
      dataIndex: "invoice_number",
      key: "invoice_number",
      width: "15%",
    },
    {
      title: "Invoice Date",
      dataIndex: "invoice_datetime",
      key: "invoice_datetime",
      width: "20%",
    },

    {
      title: "Subject",
      dataIndex: "subject",
      key: "subject",
      width: "30%",
    },
    {
      title: "Receiver",
      dataIndex: "receiver",
      key: "receiver",
    },
    {
      title: "Action",
      dataIndex: "",
      key: "x",
      render: (_,invoice) => (
        <Space>
          <Button
            type="primary"
            icon={<EyeOutlined />}
            onClick={() => navigate(`/invoice_details/${invoice.id}`)}
          >
            View Detail
          </Button>
        </Space>
      ),
    },
  ];
  const handleChange = (pagination)=>
  {
      setPage(pagination);
  }
  if (isFetching) return <Skeleton active />;
  return (
    <>
      <Space direction="vertical" size="middle" style={{ display: "flex" }}>
        <PageHeader title="All Invoice" />
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24} className="gutter-row">
            <Table
              columns={columns}
              dataSource={invoiceData.data}
              pagination={{
                pageSize: 10,
                total: invoiceData.meta.total,
                onChange: handleChange,
                current:invoiceData.meta.current_page
              }}
            />
          </Col>
        </Row>
      </Space>
    </>
  );
}

export default Invoices;
