import {
  InboxOutlined,
  MinusCircleOutlined,
  PlusOutlined,
  RightSquareFilled,
  UploadOutlined,
} from "@ant-design/icons";
import {
  Button,
  Checkbox,
  Col,
  Form,
  Input,
  PageHeader,
  Row,
  Space,
  Upload,
  message,
  Divider,
  Radio,
} from "antd";
import TextArea from "antd/lib/input/TextArea";
import React from "react";
import { useEffect } from "react";
import { useState } from "react";
import { useNavigate } from "react-router";
import Services from "../../components/Services";
import { useAddRegistrationMutation } from "../../services/registrationApi";
import { NepaliDatePicker } from "nepali-datepicker-reactjs";
import "nepali-datepicker-reactjs/dist/index.css";
//import Calendar from "@sbmdkl/nepali-datepicker-reactjs";
// import Calendar from "@sbmdkl/nepali-datepicker-reactjs";
// import "@sbmdkl/nepali-datepicker-reactjs/dist/index.css";

const NewRegistration = () => {
  const navigate = useNavigate();
  const [fileList, setFileList] = useState([]);
  const [addRegistration, { data: registrationData, error, isSuccess }] =
    useAddRegistrationMutation();

  const formRef = React.createRef();
  
  const onFinish = async (registration) => {
    console.log(registration);
    let formData = new FormData();
    fileList.forEach((file) => {
      formData.append("attachments[]", file);
    });

    for (const [key, value] of Object.entries(registration)) {
      if (key === "documents") {
        value.forEach((element) => {
          formData.append("files_name[]", element.file_name);
        });
      }
    }
    for (const [key, value] of Object.entries(registration)) {
      if (value !== undefined && key !== "documents")
        formData.append(key, value);
    }
    for (var pair of formData.entries()) {
      console.log(pair[0] + ", " + pair[1]);
    }
    await addRegistration(formData);
  };
  useEffect(() => {
    if (isSuccess) {
      message.success(registrationData.success);
      if (registrationData.registration.registration_number) {
        let registration_id = registrationData.registration.id;
        navigate(`/assign_document/${registration_id}`);
      } else navigate("/registrations");
    }
  }, [registrationData]);
  const sendToDepartment = () => {
    const registration = formRef.current.getFieldValue();
    onFinish(registration);
  };
  const [date, setDate] = useState("");
  const handleDate = ({ bsDate}) => {
    setDate({ date: bsDate });
  };
  const urgency = [
    { label: "None", value: "none" },
    { label: "Important", value: "important" },
    { label: "Very Important", value: "very_important" },
    { label: "Urgent", value: "urgent" },
  ];
  const secrecy = [
    { label: "None", value: "none" },
    { label: "Confidential", value: "confidential" },
    { label: "Top Secret", value: "top_secret" },
  ];

  return (
    <>
      <Space direction="vertical" size="middle" style={{ display: "flex" }}>
        <PageHeader
          title="New Registration"
          onBack={() => window.history.back()}
        />
        <Form
          layout="vertical"
          ref={formRef}
          onFinish={onFinish}
          encType="multipart/form-data"
        >
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={10}>
              <Form.Item label="Registration Number" name="registration_number">
                <Input />
              </Form.Item>
            </Col>
            <Col span={10}>
              <Form.Item label="Registration Date" name="registration_date">
                {/* <Calendar onChange={(e)=>handleDate} className="ant-input" language="ne" value={date} /> */}
                <NepaliDatePicker
                  inputClassName="ant-input"
                  value={date}
                  onChange={(value) => setDate(value)}
                  options={{ calenderLocale: "ne", valueLocale: "en" }}
                />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={10}>
              <Form.Item label="Letter Number" name="letter_number">
                <Input />
              </Form.Item>
            </Col>
            <Col span={10}>
              <Services />
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={10}>
              <Form.Item
                label="Subject"
                name="subject"
                rules={[{ required: true, message: "Please enter subject" }]}
              >
                <Input />
              </Form.Item>
            </Col>
            <Col span={10}>
              <Form.Item
                label="Sender"
                name="sender"
                rules={[{ required: true, message: "Please enter sender" }]}
              >
                <Input />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={10}>
              <Form.Item label="Invoice Number" name="invoice_number">
                <Input />
              </Form.Item>
            </Col>
            <Col span={10}>
              <Form.Item label="Invoice Date" name="invoice_date">
                {/* <Calendar onChange={handleDate} className="ant-input" /> */}
                <NepaliDatePicker
                  inputClassName="ant-input"
                  value={date}
                  onChange={(value) => setDate(value)}
                  options={{ calenderLocale: "ne", valueLocale: "en" }}
                />
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={10}>
              <Form.Item label="Urgency" name="urgency" initialValue="none">
                <Radio.Group
                  options={urgency}
                  optionType="button"
                ></Radio.Group>
              </Form.Item>
            </Col>
            <Col span={10}>
              <Form.Item name="secrecy" label="Secrecy" initialValue="none">
                <Radio.Group
                  options={secrecy}
                  optionType="button"
                ></Radio.Group>
              </Form.Item>
            </Col>
          </Row>

          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={20}>
              <Form.Item
                name="registration_remarks"
                label="Remarks"
                rules={[{ required: true, message: "Please enter remarks" }]}
              >
                <TextArea rows={4} />
              </Form.Item>
            </Col>
          </Row>

          <Form.List name="documents">
            {(fields, { add, remove }) => (
              <>
                <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
                  <Col span={20}>
                    {fields.map(({ key, name }) => (
                      <Space
                        key={key}
                        style={{
                          display: "flex",
                          marginBottom: 8,
                        }}
                        align="baseline"
                      >
                        <Form.Item
                          label="Document"
                          rules={[
                            {
                              required: true,
                              message: "Please upload at least one document",
                            },
                          ]}
                          name={[name, "file"]}
                        >
                          <Input
                            type="file"
                            onChange={(e) =>
                              setFileList([...fileList, e.target.files[0]])
                            }
                          />
                        </Form.Item>

                        <Form.Item name={[name, "file_name"]} label="File Name">
                          <Input />
                        </Form.Item>

                        <MinusCircleOutlined
                          className="dynamic-delete-button"
                          onClick={() => remove(name)}
                        />
                      </Space>
                    ))}
                  </Col>
                </Row>
                <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
                  <Col span={20}>
                    <Form.Item>
                      <Button
                        type="dashed"
                        onClick={() => add()}
                        block
                        icon={<PlusOutlined />}
                      >
                        Click Here To Add Document
                      </Button>
                    </Form.Item>
                  </Col>
                </Row>
              </>
            )}
          </Form.List>
          <Row gutter={{ xs: 8, sm: 16, md: 24, lg: 32 }}>
            <Col span={20}>
              <Space
                direction="horizontal"
                size="middle"
                style={{ display: "flex" }}
              >
                <Button type="primary" htmlType="submit">
                  Save
                </Button>
                <Button
                  type="default"
                  onClick={() => sendToDepartment()}
                  value="sendToDepartment"
                >
                  Send to Department
                </Button>
              </Space>
            </Col>
          </Row>
        </Form>
      </Space>
    </>
  );
};

export default NewRegistration;
