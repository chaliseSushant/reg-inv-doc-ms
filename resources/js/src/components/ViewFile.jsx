import {
  CaretDownOutlined,
  DeleteColumnOutlined,
  DownloadOutlined,
  DownOutlined,
  EditOutlined,
  SendOutlined,
} from "@ant-design/icons";
import { Button, Dropdown, PageHeader, Skeleton, Menu, Space } from "antd";
import React, { useState } from "react";
import { useEffect } from "react";
import { useParams } from "react-router";
import AddRevision from "../pages/drawers/AddRevision";
import { useGetFileQuery } from "../services/fileApi";
import { useGetRevisionsQuery } from "../services/revisionApi";

const ViewFile = () => {
  const { file_id } = useParams();
  const { data: revisionData, isSuccess: isRevisionSuccess } =
    useGetRevisionsQuery(file_id);
  const { data: fileData, isSuccess: isFileSuccess } = useGetFileQuery(file_id);

  const [file, setFile] = useState();
  const [isVisible, setIsVisible] = useState(false);

  const showDrawer = () => {
    setIsVisible(true);
  };
  const handleClick = () => {
    setIsVisible(!isVisible);
  };
  // const [files, setFiles] = useState(fileData || []);
  // const [revisions, setRevisions] = useState(revisionData || []);

  useEffect(() => {
    isFileSuccess && setFile(fileData.revision.url);
  }, [isFileSuccess]);
  const menu = isRevisionSuccess && (
    <Menu
      items={revisionData.map((revision) => {
        return {
          key: revision.id,
          label: (
            <a key={revision.id} href="#" onClick={() => setFile(revision.url)}>
              {revision.created_at}
            </a>
          ),
        };
      })}
    ></Menu>
  );

  if (!isFileSuccess) return <Skeleton active />;
  return (
    <>
      <PageHeader
        title={fileData.name}
        onBack={() => window.history.back()}
        extra={[
          <Button
            key="download"
            type="primary"
            href={fileData.revision.url}
            download
            icon={<DownloadOutlined />}
          >
            Download
          </Button>,
          <Button
            key="update"
            type="primary"
            onClick={handleClick}
            icon={<EditOutlined />}
          >
            Update
          </Button>,
          <Dropdown overlay={menu} trigger={["click"]}>
            <Button type="primary">
              <Space>
                View Revisions
                <DownOutlined />
              </Space>
            </Button>
          </Dropdown>,
          <Button key="delete" type="danger" icon={<DeleteColumnOutlined />}>
            Delete
          </Button>,
        ]}
      />
      {file && (
        <iframe
          src={file + "#zoom=FitH"}
          height={800}
          width="100%"
          frameBorder="0"
        ></iframe>
      )}
      <AddRevision
        showDrawer={isVisible}
        handleClick={handleClick}
        file_id={file_id}
      />
    </>
  );
};

export default ViewFile;
