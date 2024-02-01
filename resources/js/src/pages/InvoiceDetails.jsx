import { PageHeader, Skeleton, Space, Row, Col, Descriptions } from "antd";
import React from "react";
import { useParams } from "react-router";
import ViewInvoiceDocument from "../components/ViewInvoiceDocument";
import {
  useGetInvoiceDocumentsQuery,
  useGetInvoiceQuery,
} from "../services/invoiceApi";

const InvoiceDetails = () => {
  const { invoice_id } = useParams();
  const { data: invoiceData, isSuccess } = useGetInvoiceQuery(invoice_id);
  const { data: invoiceDocument, isSuccessInvoiceDocument } =
    useGetInvoiceDocumentsQuery(invoice_id);
  if (!isSuccess) return <Skeleton active />;
  return (
    <>
      <Space direction="vertical" style={{ display: "flex" }}>
        <PageHeader
          title="Invoice Details"
          onBack={() => window.history.back()}
        />
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24}>
            <Descriptions title="Invoice Details" bordered>
              <Descriptions.Item label="Invoice Number">
                {invoiceData.invoice_number}
              </Descriptions.Item>
              <Descriptions.Item label="Invoice Date" span={2}>
                {invoiceData.invoice_datetime}
              </Descriptions.Item>
              <Descriptions.Item label="Attender Book Number">
                {invoiceData.letter_number}
              </Descriptions.Item>
              <Descriptions.Item label="Subject" span={3}>
                {invoiceData.subject}
              </Descriptions.Item>

              <Descriptions.Item label="Sender">
                {invoiceData.sender}
              </Descriptions.Item>
              <Descriptions.Item label="Receiver" span={2}>
                {invoiceData.receiver}
              </Descriptions.Item>
              <Descriptions.Item label="Remarks" span={3}>
                {invoiceData.remarks}
              </Descriptions.Item>
            </Descriptions>
          </Col>
        </Row>
        <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
          <Col span={24}>
            <ViewInvoiceDocument invoice_id={invoiceData.id}/>
          </Col>
        </Row>
      </Space>
    </>
  );
};

export default InvoiceDetails;
